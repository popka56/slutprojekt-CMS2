<?php
/*
* Plugin name: Frakt med bud
*/

// Plugin som ska räkna ut hur mycket köparens varor väger och bestämmer vilken fraktklass den hamnar i.
// Ska räkna ut avståndet till köparen och bestämma pris för frakt.

//  Options page
function loadOptionspages()
{
  acf_add_options_page(array(
    'page_title' => 'Frakt priser',
    'menu_title' => 'Frakt priser',
    'menu_slug' => 'frakt-general-settings',
    'capability' => 'edit_posts',
    'redirect' => false
  ));
}

require('acf_shipping_plugin.php');
require('secret.php');
// $apiKey = getapiKey();

add_action('acf/init', 'loadOptionspages');

// Funkton för att lägga till class
function your_shipping_method_init()
{
  // Min shipping class
  class WC_Your_Shipping_Method extends WC_Shipping_Method
  {

    public $key;


    public function __construct()
    {
      $this->key = getapiKey();
      $this->id = 'your_shipping_method';
      $this->title = 'Your Shipping Method';
      $this->enabled = 'yes';
      // $this->init();
    }

    function init()
    {
      // Laddar settings för api
      $this->init_form_fields();
      $this->init_settings();

      // Spara settings i admin
      add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));
    }

    //  funktion som kollar hur mycket beställningen väger
    function getCartWeight()
    {

      $cart = WC()->cart;
      $totalweight = 0;

      foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $product_id = $cart_item['product_id'];
        $quantity = $cart_item['quantity'];
        $price = WC()->cart->get_product_price($product);
        $subtotal = WC()->cart->get_product_subtotal($product, $cart_item['quantity']);
        $link = $product->get_permalink($cart_item);

        $meta = wc_get_formatted_cart_item_data($cart_item);
        // $product = (array)$product;
        // $product = json_decode(json_encode($product), true);
        // var_dump($product->get_weight());
        $weight = $quantity * $product->get_weight();
        // var_dump($weight);
        $totalweight = $totalweight + $weight;
      }

      return $totalweight;
    }

    // funktion som väljer viktklass
    function chooseWeightClass()
    {
      $totalWeight = $this->getCartWeight();
      $price = 0;

      if ($totalWeight <= 3) {
        $price = absint(get_field('viktklass_1', 'options'));
      } else if ($totalWeight >= 4 && $totalWeight <= 8) {
        $price = absint(get_field('viktklass_2', 'options'));
      } else if ($totalWeight > 8) {
        $price = absint(get_field('viktklass_3', 'options'));
      }

      return $price;
    }

    // funktion som hämtar köparens information och tar reda på avståndet från lagret
    function getBuyerInfo()
    {
      $cart = WC()->cart;
      $city = $cart->get_customer()->get_shipping_city();
      $adress = $cart->get_customer()->get_shipping_address();
      $postcode = $cart->get_customer()->get_shipping_postcode();
      $country = $cart->get_customer()->get_shipping_country();
      $state = $cart->get_customer()->get_shipping_state();

      // Ebbe Lieberathsgatan 16 412 65 Göteborg
      $warehouseLocation = [
        'longt' => 12.00053,
        'latt' => 57.68005
      ];

      $destination = $this->getLongLat($adress, $city);

      $routeinfo = $this->calculateDistance($warehouseLocation, $destination);
      // Avstånd i meter
      $routelength = $routeinfo['routes'][0]['sections'][0]['summary']['length'];

      return $routelength;
    }

    // Funktion för att byta adressen mot long/lat
    public static function getLongLat($adress, $city)
    {
      // $adressarray = explode(' ', $adress);
      $newadress = str_replace(' ', '+', $adress);
      $response = wp_remote_get('https://geocode.xyz/' . $newadress . '+' . $city . '?json=1');
      // $response = wp_remote_get('https://geocode.xyz/Rörbecksgatan,+14+Falkenberg?json=1');
      $body = wp_remote_retrieve_body($response);
      $formated_body_array = json_decode($body, true);
      return $formated_body_array;
    }

    // Funktion som räknar ut avståndet mellan lagret och destinationen
    public function calculateDistance($warehouse, $destination)
    {
      $response = wp_remote_get('https://router.hereapi.com/v8/routes?transportMode=car&origin=' . $warehouse['latt'] . ',' . $warehouse['longt'] . '&destination=' . $destination['latt'] . ',' . $destination['longt'] . '&return=summary&apiKey=' . $this->key);
      $body = wp_remote_retrieve_body($response);
      $formated_body_array = json_decode($body, true);
      return $formated_body_array;
    }

    function calculateDeliveryPrice()
    {

      // Väljer viktklass
      $weightClass = $this->chooseWeightClass();

      // Avstånd mellan lager och destination
      $route = $this->getBuyerInfo();
      $routeprice = 0;
      if ($route <= 10000) {
        $routeprice = 0;
      } else if ($route >= 10001 && $route <= 50000) {
        $routeprice = 50;
      } else if ($route > 50000) {
        $routeprice = 150;
      }

      $price = [
        'weightprice' => $weightClass,
        'routeprice' => $routeprice,
        'total' => $routeprice + $weightClass
      ];

      return $price;
    }

    public function calculate_shipping($package = [])
    {

      $cost = $this->calculateDeliveryPrice();
      $rate = [
        'label' => $this->title,
        'cost' => $cost['total'],
      ];

      $this->add_rate($rate);
    }
    // end; class
  }
  // end; func
}

add_action('plugins_loaded', 'your_shipping_method_init');

function add_your_shipping_method($methods)
{
  $methods['your_shipping_method'] = 'WC_Your_Shipping_Method';
  return $methods;
}

add_filter('woocommerce_shipping_methods', 'add_your_shipping_method');

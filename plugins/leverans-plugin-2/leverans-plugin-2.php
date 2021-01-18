<?php
/*
Plugin Name: Slutprojekt - Leverans Plugin 2
Plugin URI: 
description: Lägger till val att hämta i valfri butik under checkout.
Version: 1.0
Author: Hugo Viklund
Author URI: 
License: GPL2
*/

//Undviker tillgång till filen direkt från en URL
if(!defined('ABSPATH')){
    die;
}
 
//Hooks
add_filter( 'woocommerce_shipping_methods', 'add_ehk_shipping_option' );
function add_ehk_shipping_option($methods) {
	$methods['ehk_shipping'] = 'EHK_Shipping'; //Klassnamnet
	return $methods;
}
add_action('plugins_loaded', 'init_ehk_shipping_option');
function init_ehk_shipping_option() {
 
   //Här bygger vi vår shipping baserat på woocommerces shipping method class
   class EHK_Shipping extends WC_Shipping_Method 
   {
        public function __construct() {
            //Sätter lite standardvärden
            $this->id = 'ehk_shipping';
            $this->has_fields = true;
            $this->method_title = 'Hämta i butik';
            $this->method_description = "Hämta ditt paket i valfri butik.";

            //Ladda våra standardvärden
            $this->title = $this->get_option( 'title' );
            $this->description = $this->get_option( 'description' );
            $this->enabled = 'yes';
            $this->init_form_fields();
            $this->init_settings();
            
            //Spara med en hook
            add_action('woocommerce_update_options_shipping_' . $this->id, array($this, 'process_admin_options'));

            //För att skriva ut formuläret med butikerna
            add_action('woocommerce_review_order_before_payment', array($this, 'print_shipping_fields'), 10);
            //För att validera att en butik blivit vald
            add_action( 'woocommerce_after_checkout_validation', array($this, 'validate_shipping_fields'), 10, 2);
        }

        //Inställningarna som syns i woocommerce
        public function init_form_fields(){
            $this->form_fields = array(
                'default_price' => array( 
                    'title'       => 'Default Price',
                    'type'        => 'number',
                    'description' => 'Pris för att hämta i butik.',
                    'default'     => '5',
                    'desc_tip'    => true,
                ),
                'amount_for_no_charge' => array(
                    'title'       => 'Free Charge If Above',
                    'type'        => 'number',
                    'description' => 'Hur mycket någon måste handla för, för att få gratis upphämtning.',
                    'default'     => '30',
                    'desc_tip'    => true,
                ),
            );
        }

        //Formuläret som visas i checkout
        public function print_shipping_fields() {
            if(EHK_Shipping::is_ehk_shipping_chosen()){
                $stores = get_posts(array('post_type' => 'butiker'));
                echo '
                <div>
                    <h2>Välj den butik där du vill hämta din order</h2>
                    <span id="response"></span>
                    <select name="stores" id="stores">';
                        foreach ($stores as $store) {
                        echo '<option value="' . $store->post_title . '">' . $store->post_title . '</option>';
                        }
                    echo '</select>
                </div>';
            }
        }

        //Se till att en butik faktiskt är vald
        public function validate_shipping_fields() {
            if(EHK_Shipping::is_ehk_shipping_chosen()){
                if(!empty($_POST['stores'])) {
                    //Ordern går igenom
                } 
                else {
                    wc_add_notice('En butik måste vara vald! Ladda om sidan om du inte kan se valmöjligheterna.', 'error');
                    return false;
                }
            }
        }

        //Kollar om vår fraktmetod är vald
        public static function is_ehk_shipping_chosen(){
            $chosen_shipping_method = WC()->session->get('chosen_shipping_methods');
            if($chosen_shipping_method[0] == "ehk_shipping"){
                return true;
            }
            else{
                return false;
            }
        }

        public function calculate_shipping($package = []) {
            //Kolla om priset är mindre än vad man måste ha för att nå gratis fraktpris eller ej
            global $woocommerce;
            $subtotal = $woocommerce->cart->subtotal;
            if($subtotal > $this->get_option('amount_for_no_charge')){
                $cost = 0;
            }
            else{
                $cost = $this->get_option('default_price');
            }

            $rate = array(
                'label' => $this->title,
                'cost' =>  $cost,
            );

            $this->add_rate($rate);
        }

   }
}
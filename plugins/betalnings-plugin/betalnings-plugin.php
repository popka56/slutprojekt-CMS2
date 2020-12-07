<?php
/*
Plugin Name: Slutprojekt - Betalnings Plugin
Plugin URI: 
description: Lägger till en ny betalningsmetod för woocommerce; Faktura via personnummer.
Version: 1.0
Author: Elin, Hugo & Kristoffer
Author URI: 
License: GPL2
*/

//Undviker tillgång till filen direkt från en URL
if(!defined('ABSPATH')){
   die;
}

//Hooks
add_filter( 'woocommerce_payment_gateways', 'add_ehk_payment_option' );
function add_ehk_payment_option( $gateways ) {
	$gateways[] = 'EHK_Payment'; //Klassnamnet
	return $gateways;
}
add_action( 'plugins_loaded', 'init_ehk_payment_option' );
function init_ehk_payment_option() {
 
   //Här bygger vi vår betalningsmetod baserat på woocommerces payment gateway class
   class EHK_Payment extends WC_Payment_Gateway {

      public function __construct() {
         //Sätter lite standardvärden
         $this->id = 'ehk';
         $this->has_fields = true;
         $this->method_title = 'Faktura'; //Titeln i woocommerces "Payment" inställning
         $this->method_description = 'Skickar faktura via ett giltigt personnummer.'; //Beskrivningen i woocommerces "Payment" inställning
         $this->supports = array(
            'products'
         );
         
         //Ladda våra standardvärden
         $this->init_form_fields();
         $this->init_settings();
         $this->title = $this->get_option( 'title' );
         $this->description = $this->get_option( 'description' );
         $this->enabled = $this->get_option( 'enabled' );
         
         //Spara med en hook
         add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );
         
      }

      //Inställningssidan för betalningsmetoden på woocommerces payment sida
      public function init_form_fields(){
         $this->form_fields = array(
            'enabled' => array(
               'title'       => 'Aktivera/Avaktivera',
               'label'       => 'Aktivera faktura via personnummer',
               'type'        => 'checkbox',
               'description' => '',
               'default'     => 'no'
            ),
            'title' => array(
               'title'       => 'Title',
               'type'        => 'text',
               'description' => 'Namnet på betalningsmetoden kunden ser i checkout.',
               'default'     => 'Faktura',
               'desc_tip'    => true,
            ),
            'description' => array(
               'title'       => 'Description',
               'type'        => 'textarea',
               'description' => 'Beskrivningen som kunden ser i checkout.',
               'default'     => 'Skriv in ditt personnummer så skickar vi en faktura till dig.',
            )
         );

      }

      //Formuläret som visas i checkout
      public function payment_fields() {
         echo '
         <p>' . $this->description . '</p>
         <fieldset id="wc-' . esc_attr($this->id) . '-faktura-form" class="wc-payment-form" style="background:transparent;">
            <div class="form-row form-row-wide">
               <label>Personnummer (ååmmdd-nnnn) <span class="required">*</span></label>
               <input id="ehk_pnr" name="billing_ssn" type="text" autocomplete="off">
            </div>
         </fieldset>';
      }

      //Ge error om inget giltigt personnummer skrivits in
      public function validate_fields() {
         //Validera input
         if(!empty($_POST['billing_ssn']) && (Personnummer::validateString($_POST['billing_ssn']) == true)) {
            return true;
         }
         else{
            wc_add_notice('Du måste skriva in ett giltigt personnummer!', 'error');
            return false;
         }

      }

      //Här skulle kod som faktiskt genomförde beställningen var (men det ingår inte i uppgiften så vi skippar det)
      public function process_payment( $order_id ) {
   
         global $woocommerce;
         $order = wc_get_order( $order_id );
      
         //Prata med en API eller något för att skicka iväg en avi till rätt person med vårt personrn etc...
      
      }

   }

   //En klass för att validera personnr med luhn-algoritmen
   class Personnummer
   {
      private
         $year  = 0,
         $month = 0,
         $day   = 0,
         $bn    = 0;
      
      public function __construct(int $year, int $month, int $day, int $bn)
      {
         $this->year  = $year;
         $this->month = $month;
         $this->day   = $day;
         $this->bn    = $bn;
      }
      
      public static function validateString(string $personnummer) : bool
      {
         return self::createFromString($personnummer) !== null;
      }
      
      public static function createFromString(string $personnummer) : ?Personnummer
      {
         
         if(preg_match("/^
               (\d{2}) # 1: År
               (\d{2}) # 2: Månad
               (\d{2}) # 3: Dag
               ([+-])  # 4: Skiljetecken
               (\d{3}) # 5: Födelsenummer
               (\d{1}) # 6: Kontrollsiffra
         $/x", $personnummer, $m))
         {
               $year  = (int)$m[1];
               $month = (int)$m[2];
               $day   = (int)$m[3];
               $sep   = $m[4];
               $bn    = (int)$m[5];
               $check = (int)$m[6];
               
               //Normalisera födelseåret (+ är om personen är över 100)
               $year = self::normalizeYear($year, $sep === "+");
               
               //Giltigt datum? (Kollar även samordningsnr; 60 adderas på sådana nr)
               if(checkdate($month, $day > 60 ? $day - 60 : $day, $year))
               {
                  //Verifiera kontrollsiffra
                  if($check === self::calcCheckDigit($year, $month, $day, $bn))
                  {
                     return new self($year, $month, $day, $bn);
                  }
               }
         }
         
         return null;
      }
      
      private static function normalizeYear(int $birthYear, bool $hundredOrOlder = false) : int
      {
         $currentYear    = (int)date("Y");
         $currentCentury = (int)floor($currentYear / 100) * 100;
         $currentYear    = $currentYear % 100;
         
         if($hundredOrOlder)
         {
               if($birthYear > $currentYear)
               {
                  return $birthYear + $currentCentury - 200;
               }
               else
               {
                  return $birthYear + $currentCentury - 100;
               }
         }
         else
         {
               if($birthYear > $currentYear)
               {
                  return $birthYear + $currentCentury - 100;
               }
               else
               {
                  return $birthYear + $currentCentury;
               }
         }
      }
      
      private static function calcCheckDigit(int $year, int $month, int $day, int $bn) : int
      {
         $digits = sprintf(
               '%02d%02d%02d%03d',
               substr((string)$year, 2, 2),
               $month,
               $day,
               $bn
         );
         
         $sum = 0;
         
         //Luhn-algoritmen
         for($i = 0, $c1 = strlen($digits); $i < $c1; ++$i)
         {
               //För varje tecken multipliceras siffran omväxlande mellan 1 och 2
               $t = (string)((int)$digits[$i] * ($i % 2 === 0 ? 2 : 1));
               
               for($n = 0, $c2 = strlen($t); $n < $c2; ++$n)
               {
                  $sum += (int)$t[$n];
               }
         }
         
         //Resten
         $check = 10 - $sum % 10;
         return $check === 10 ? 0 : $check;
      }
      
      //Hämta datum data
      public function getYear() : int
      {
         return $this->year;
      }
      
      public function getMonth() : int
      {
         return $this->month;
      }
      
      public function getDay() : int
      {
         return $this->day;
      }
      
      public function getBirthNumber() : int
      {
         return $this->bn;
      }
      
      public function getGender() : int
      {
         return $this->bn % 2;
      }
      
      public function getCheckDigit() : int
      {
         return self::calcCheckDigit($this->year, $this->month, $this->day, $this->bn);
      }
      
      public function toString() : string
      {
         return sprintf(
               '%s%02d%02d%s%03d%d',
               substr((string)$this->year, 2, 2),
               $this->month,
               $this->day,
               ((int)date("Y") - $this->year < 100 ? "-" : "+"),
               $this->bn,
               $this->getCheckDigit()
         );
      }
      
      public function __toString() : string
      {
         return $this->toString();
      }
   }

}
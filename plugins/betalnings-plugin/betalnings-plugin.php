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
         <fieldset id="wc-' . esc_attr( $this->id ) . '-faktura-form" class="wc-payment-form" style="background:transparent;">
            <div class="form-row form-row-wide">
               <label>Personnummer <span class="required">*</span></label>
               <input id="ehk_pnr" type="text" autocomplete="off">
            </div>
         </fieldset>';
      }
   }
}
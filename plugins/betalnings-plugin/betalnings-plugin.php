<?php
/*
Plugin Name: Slutprojekt - Betalnings Plugin
Plugin URI: 
description:
Version: 1.0
Author: Elin, Hugo & Kristoffer
Author URI: 
License: GPL2
*/

//Undviker tillgång till filen direkt från en URL
if(!defined('ABSPATH')){
   die;
}

class EHKPayment
{
   //Lite förberedelser
   function __construct() {
      add_filter( 'woocommerce_review_order_before_payment', array( $this, 'create_ehk_payment_form' ), 10, 1 ); //TODO: Hitta rätt filter att använda, kanske lägg till direkt till wooceommerce payment gateways?
      wp_enqueue_script( 'script', plugin_dir_url( __FILE__ ) . 'js/betalning.js');
   }

   //Skapa tables
   function on_plugin_activate() {
      global $wpdb;
      $table_name = $wpdb->prefix . "ehk_bills";
      
      //kolla om ehk_bills redan finns
      $query = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));
      if (!$wpdb->get_var($query) == $table_name){
         //skapa ett table
         $charset_collate = $wpdb->get_charset_collate();

         $sql = "CREATE TABLE $table_name (
           id mediumint(9) NOT NULL AUTO_INCREMENT,
           time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
           email text NOT NULL,
           paid int DEFAULT 0 NOT NULL,
           PRIMARY KEY  (id)) 
           $charset_collate;";

         $path = preg_replace('/wp-content.*$/', '', __DIR__);
         require_once($path.'wp-admin/includes/upgrade.php');
         dbDelta($sql);
      }
      flush_rewrite_rules();
   }

   //Ta bort den sparade väder platsen och databasen för kontaktformuläret vid avinstallation
   function on_plugin_uninstall(){
      global $wpdb;
      $table_name = $wpdb->prefix . 'ehk_bills';
      $sql = "DROP TABLE IF EXISTS $table_name";
      $wpdb->query($sql);
   }

   //Skapa själva input:en
   public function create_ehk_payment_form(){      
      echo '
      <div>
         <h2>Faktura med mejl</h2>
         <span id="response"></span>
            <label for="email">E-Mail fakturan ska skickas till:</label>
            <input type="text" id="email" required>
            <br>
            <input type="submit" value="Submit" onclick="submit_form()">
      </div>';
   }

   //Skriv ut en lista med alla utskick
   public static function get_ehk_bills(){
      global $wpdb;
      $results = $wpdb->get_results( 
                  $wpdb->prepare("SELECT * FROM {$wpdb->prefix}ehk_bills LIMIT 10") 
               );
      echo '<ul>';
      foreach($results as $result){
         echo  '<li>' . 
               'Skickad: ' . $result->time . '<br>' .
               'Till: ' . $result->email . '<br>' .
               'Betald: ' . $result->paid . //TODO: lägg en if-sats för att skriva Ja eller Nej istället för 0 eller 1 
               '</li>';

      }
      echo '</ul>';
   }
}

//Registrering-hooks
$ehkPayment = new EHKPayment();
register_activation_hook(__FILE__, array($ehkPayment, 'on_plugin_activate'));
register_activation_hook(__FILE__, array($ehkPayment, 'on_plugin_uninstall'));
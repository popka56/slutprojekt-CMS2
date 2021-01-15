<?php
/*
Plugin Name: Slutprojekt - Test Plugin
Plugin URI: 
description: Testar olika funktioner från temat och plugins skapade av EHK.
Version: 1.0
Author: Elin, Hugo & Kristoffer
Author URI: 
License: GPL2
*/

//Undviker tillgång till filen direkt från en URL
if(!defined('ABSPATH')){
    die;
}

//Vi använder en klass med statiska funktioner som vi kan kalla från en testsida i wp-admin
class EHKTestPlugin
{
   function __construct() {
      add_action('admin_menu', array($this, 'add_plugin_page'));
   }
 
   //Om något ska hända vid start
   function on_plugin_activate() {

   }

   //Om något ska ske vid avinstallation
   function on_plugin_uninstall(){
    
   }
 
   //Lägg till ny sida i wp-admin
   public function add_plugin_page(){
      add_menu_page( 'EHK Test Plugin', 
                     'Test Plugin', 
                     'manage_options', 
                     'ehk_test_plugin', 
                     array($this, 'ehk_testing_page'), //funktionen som hämtar templaten
                     'dashicons-admin-generic', 
                     25 );
   }

   //Hämta template för testssidan
   function ehk_testing_page(){
      require_once plugin_dir_path( __FILE__ ) . 'testing.php';
   }
 
   //Funktion för att testa validateString funktionen från betalningspluginet
   public static function is_actually_valid_ssn(string $ssn, bool $expectedOutput){
 
      $output = Personnummer::validateString($ssn);
 
      if($expectedOutput){
         $expectedOutputS = 'true';
      }
      else{
         $expectedOutputS = 'false';
      }
 
      if($output){
         $outputS = 'true';
      }
      else{
         $outputS = 'false';
      }
       
      if($output === $expectedOutput){
         echo '<p><span style="color: green;">Testet lyckades!</span> Personnummret "' . $ssn . '" förväntades returnera <span style="color: blue;">' . $expectedOutputS . '</span> och returnerade <span style="color: blue;">' . $outputS . '</span>.</p>';
         return true;
      }
      else{
         echo '<p><span style="color: red;">Testet misslyckades!</span> Personnummret "' . $ssn . '" förväntades returnera <span style="color: blue;">' . $expectedOutputS . '</span> men returnerade <span style="color: blue;">' . $outputS . '</span>.</p>';
         return false;
      }
   }

   //Funktion för att testa om latituden blir rätt
   public static function is_correct_long_lat(string $streetAdress, string $city, $expectedLatt, $expectedLongt){
      $output = WC_Your_Shipping_Method::getLongLat($streetAdress, $city);
      
      //Ifall API:n inte ger respons
      if($output["latt"] == null){
         $output["latt"] = "null";
      }

      if($output["longt"] == null){
         $output["longt"] = "null";
      }

      if($output["latt"] == $expectedLatt && $output["longt"] == $expectedLongt){
         echo '<p><span style="color: green;">Testet lyckades!</span> Lattituden och longituden förväntades bli <span style="color: blue;">' . $expectedLatt . '</span> respektive <span style="color: blue;">' . $expectedLongt .  '</span> och blev <span style="color: blue;">' . $output["latt"] . '</span> respektive <span style="color: blue;">' . $output["longt"] . '</span>.</p>';
         return true;
      }
      else{
         echo '<p><span style="color: red;">Testet misslyckades!</span> Lattituden och longituden förväntades bli <span style="color: blue;">' . $expectedLatt . '</span> respektive <span style="color: blue;">' . $expectedLongt .  '</span> men blev <span style="color: blue;">' . $output["latt"] . '</span> respektive <span style="color: blue;">' . $output["longt"] . '</span>.</p>';
         return false;
      }
   }

   //Test av så kallad "cache buster" funktion
   public static function is_cache_busted($expectedFailedOutput){
      $output = version_id();
      if($output === $expectedFailedOutput){
         echo '<p><span style="color: red;">Testet misslyckades!</span> Utvalda filer fick versionsnummret <span style="color: blue;">' . $output . '</span>.</p>';
         return false;
      }
      else{
         echo '<p><span style="color: green;">Testet lyckades!</span> Utvalda filer fick versionsnummret <span style="color: blue;">' . $output . '</span>.</p>';
         return true;
      }
   }

   //Test av alla testfunktionerna
   public static function are_the_test_functions_working_correctly(){
      $function1 = self::is_actually_valid_ssn('640823-3234', true); //Ska lyckas
      $function2 = self::is_correct_long_lat("Rörbecksgatan, 14", "Falkenberg", 56.90558, 12.48476); //Ska lyckas
      $function3 = self::is_cache_busted("1.0"); //Ska lyckas
      if(($function1 && $function2 && $function3 === true)){
         echo '<p><span style="color: green;">Alla test genomfördes korrekt!</span></p>';
      }
      else{
         echo '<p><span style="color: red;">Något av testen misslyckades!</span></p>';
      }
   }
}
 
//Registrering-hooks
$ehkTestPlugin = new EHKTestPlugin();
register_activation_hook(__FILE__, array($ehkTestPlugin, 'on_plugin_activate'));
register_activation_hook(__FILE__, array($ehkTestPlugin, 'on_plugin_uninstall'));
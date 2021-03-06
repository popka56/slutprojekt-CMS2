<?php

add_theme_support('post-thumbnails');

//Cache Buster!
define('VERSION', '1.0');
function version_id()
{
	if (WP_DEBUG)
		return time();
	return VERSION;
}

function slutprojekt_files()
{
	//wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css', array(), rand(0,999999), 'all');
	wp_enqueue_style('style.css', get_stylesheet_uri(), '', version_id());
	wp_enqueue_style('account.css', get_template_directory_uri() . '/assets/css/account.css', '', version_id());
	wp_enqueue_script('theme-js', get_template_directory_uri() . '/index.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'slutprojekt_files');

// Menus
function menus()
{
	register_nav_menus(array(
		'main-menu' 	=> 'Main Menu',
		'footer-menu' => 'Footer Menu',
		'mobile-menu' => 'Mobile Menu'
	));
}
add_action('init', 'menus');

// Options Page
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' 	=> 'Footer',
		'menu_title'	=> 'Footer Settings',
		'menu_slug' 	=> 'footer-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

// Custom post type, Butiker
function createPostType()
{
	register_post_type('butiker', ['label' => 'Butiker', 'public' => true, 'show_in_rest' => true]);
}

add_action('init', 'createPostType');

// ACF för custom post type

if (
	function_exists('acf_add_local_field_group')
) :

	acf_add_local_field_group(array(
		'key' => 'group_5fd32f395f38c',
		'title' => 'Butiksadress',
		'fields' => array(
			array(
				'key' => 'field_5fd32f52ee63b',
				'label' => 'Adress',
				'name' => 'adress',
				'type' => 'text',
				'instructions' => 'Adress format t.ex. \'Ebbe Lieberathsgatan 16 Göteborg\'.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5ffee9b6ddfce',
				'label' => 'Longitud',
				'name' => 'longitud',
				'type' => 'number',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array(
				'key' => 'field_5ffee9c6ddfcf',
				'label' => 'Latitud',
				'name' => 'latitud',
				'type' => 'number',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'butiker',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

endif;

// Funktion som hämtar ID för produkter som är på rea
function get_products_on_sale_ID()
{
	$productsID = [];

	$onsaleproducts =
		WC_Product_Data_Store_CPT::get_on_sale_products();

	foreach ($onsaleproducts as $product) {
		array_push($productsID, $product->id);
	}

	return $productsID;
}

// Funktion som hämtar array med alla produkter som är på rea
function get_array_for_products_on_sale()
{
	$products = [];
	$productids = get_products_on_sale_ID();
	foreach ($productids as $id) {
		$product = wc_get_product($id);
		array_push($products, $product);
	}
	return $products;
}

// Skicka ajaxdata custom post type

add_action('wp_ajax_butiker', 'send_longlat_butik');

function send_longlat_butik()
{

	$butiskarray = [];
	$ids = [];

	$args = [
		'post_type' => 'butiker',
		'post_status' => 'publish'
	];

	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$post_id = get_the_ID();
			$metadata = get_post_meta($post_id);
			array_push($butiskarray, $metadata);
		}
	}

	wp_send_json($butiskarray);
	die();
}

// Kortar av the_excerpt så det inte blir lika många ord
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

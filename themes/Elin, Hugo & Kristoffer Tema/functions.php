<?php

add_theme_support('post-thumbnails');

function slutprojekt_files()
{
	wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css', array(), null, 'all');
	wp_enqueue_script('theme-js', get_template_directory_uri() . '/index.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'slutprojekt_files');


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

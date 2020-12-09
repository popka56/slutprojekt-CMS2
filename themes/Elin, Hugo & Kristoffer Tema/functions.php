<?php

add_theme_support('post-thumbnails');

function slutprojekt_files() {
  wp_enqueue_style('theme-style', get_stylesheet_directory_uri() . '/style.css', array(), null, 'all');
  wp_enqueue_script('theme-js', get_template_directory_uri() . '/index.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'slutprojekt_files');


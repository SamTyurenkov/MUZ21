<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function site_scripts() {
		
    wp_enqueue_script( 'asp-utility', get_template_directory_uri() . '/js/asp-utility.js', array( 'jquery' ), filemtime(get_template_directory() . '/js/asp-utility.js'), true );
	wp_enqueue_style( 'asp-main', get_template_directory_uri() . '/css/main.css', array( ), filemtime(get_template_directory() . '/css/main.css'), 'all' );
	
}
add_action('wp_enqueue_scripts', 'site_scripts', 999);

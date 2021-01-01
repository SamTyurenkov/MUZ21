<?php
/*
Plugin Name: XMLs for REALTY
Description: Adds xml-feed for every user
Author: Sam Tyurenkov
Author URI: https://windowspros.ru
Version: 1.3
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_filter( 'template_include', 'yandex_feed_template', 99 );

function yandex_feed_template( $template ) {
    $file_name = 'yandex.php';
            // Template not found in theme's folder, use plugin's template as a fallback
    $template = dirname( __FILE__ ) . '/feeds/' . $file_name;

    return $template;
}

// Yandex.Realty RSS
add_action('init', 'AddUserXmls');
function AddUserXmls(){

$authors = get_users('role=author');
foreach ($authors as $author) {
    $author_id = esc_html($author->user_login);
    add_action('init', function() use($author_id) {
        add_feed('yandex-'.$author_id, function() {
            get_template_part('feed', 'yandex');
        });
    });
  //  $wp_rewrite->flush_rules($hard);
}

}




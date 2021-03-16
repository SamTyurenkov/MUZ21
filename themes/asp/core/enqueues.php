<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function site_scripts()
{
	if(is_singular('property')) {
		wp_enqueue_script('splide', get_template_directory_uri() . '/js/splide.min.js', array('jquery'), filemtime(get_template_directory() . '/js/splide.min.js'), true);
	}

	$ajaxurl = admin_url('admin-ajax.php');
	wp_enqueue_script('asp-main', get_template_directory_uri() . '/js/main.js', array('jquery'), filemtime(get_template_directory() . '/js/main.js'), true);

	if(is_tax('property-type')) {
		$taxonomy = get_queried_object();
		$obj_id = $taxonomy->term_id;
		$action = 'cat_post_ajax';
		$nonce = wp_create_nonce("_load_properties");
	} else if(is_category()) {
		$taxonomy = get_queried_object();
		$obj_id = $taxonomy->term_id;
		$action = 'cat_blog_ajax';
		$nonce = wp_create_nonce("_load_posts");
	} else if(is_author()) {
		$curauth = get_queried_object();//(isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
		$obj_id = $curauth->ID;
		$action = 'auth_post_ajax';
		$nonce = wp_create_nonce("_load_properties");
		wp_enqueue_script('asp-authors', get_template_directory_uri() . '/js/authors.js', array('jquery'), filemtime(get_template_directory() . '/js/authors.js'), true);
	} else if (is_home() || is_front_page()) {
		$obj_id = null;
		$action = 'more_post_ajax';
		$nonce = wp_create_nonce("_load_properties");
	} else if (is_page('adminka')) {
		$taxonomy = get_queried_object();
		$obj_id = $taxonomy->term_id;
		$nonce = wp_create_nonce("_load_properties");
		$action = 'more_post_ajax';
		wp_enqueue_script('asp-authors', get_template_directory_uri() . '/js/authors.js', array('jquery'), filemtime(get_template_directory() . '/js/authors.js'), true);
	}

	if(isset($ajaxurl) && isset($nonce))
	wp_localize_script('asp-main', 'localize', array(
		'ajaxurl' => $ajaxurl,
		'obj_id' => $obj_id,
		'action' => $action,
		'nonce' => $nonce
	));
	wp_enqueue_style('asp-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');


}
add_action('wp_enqueue_scripts', 'site_scripts', 999);

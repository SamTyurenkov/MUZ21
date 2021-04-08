<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

function site_scripts()
{
	$ajaxurl = admin_url('admin-ajax.php');
	wp_enqueue_script('asp-main', get_template_directory_uri() . '/js/main.js', array('jquery'), filemtime(get_template_directory() . '/js/main.js'), true);


	if (is_singular('property')) {
		wp_enqueue_script('splide', get_template_directory_uri() . '/js/splide.min.js', array('jquery'), filemtime(get_template_directory() . '/js/splide.min.js'), true);

		$youtubeid = get_post_meta(get_the_ID(), 'youtube-video', true);
		if (!empty($youtubeid) && $youtubeid != '') {
			wp_enqueue_script('youtubeiframe', get_template_directory_uri() . '/js/youtubeiframe.js', array('jquery'), filemtime(get_template_directory() . '/js/youtubeiframe.js'), true);
		}

		wp_enqueue_script('property', get_template_directory_uri() . '/js/property.js', array('jquery'), filemtime(get_template_directory() . '/js/property.js'), true);


		$author_id = get_the_author_meta('ID');
		$curuser = get_current_user_id();
		$editors = explode(',', get_the_author_meta('editors', $author_id));

		if (is_user_logged_in() && (in_array($curuser, $editors) || current_user_can('edit_others_posts'))) {
			wp_enqueue_script('property-author', get_template_directory_uri() . '/js/property-author.js', array('jquery'), filemtime(get_template_directory() . '/js/property-author.js'), true);

			$propertyauthor = array(
				'ajaxurl' => $ajaxurl,
				'post_id' => get_the_ID(),
				'auth_id' => $author_id,
			);
			wp_localize_script('property-author', 'propertyauthor', $propertyauthor);
		}
	} else if (is_singular('post')) {

		$author_id = get_the_author_meta('ID');
		$curuser = get_current_user_id();
		$editors = explode(',', get_the_author_meta('editors', $author_id));

		if (is_user_logged_in() && (in_array($curuser, $editors) || current_user_can('edit_others_posts'))) {
			wp_enqueue_script('blog-author', get_template_directory_uri() . '/js/blog-author.js', array('jquery'), filemtime(get_template_directory() . '/js/blog-author.js'), true);

			$blogauthor = array(
				'ajaxurl' => $ajaxurl,
				'post_id' => get_the_ID(),
				'auth_id' => $author_id,
				'post_type' => get_post_type(),
				'post_title' => get_the_title()
			);
			wp_localize_script('blog-author', 'blogauthor', $blogauthor);
		}
	}




	if (is_tax('property-type')) {
		$taxonomy = get_queried_object();
		$obj_id = $taxonomy->term_id;
		$action = 'cat_post_ajax';
	} else if (is_category()) {
		$taxonomy = get_queried_object();
		$obj_id = $taxonomy->term_id;
		$action = 'cat_blog_ajax';
	} else if (is_tag()) {
		$taxonomy = get_queried_object();
		$obj_id = $taxonomy->term_id;
		$action = 'tag_blog_ajax';
	} else if (is_author()) {
		$curauth = get_queried_object();
		$obj_id = $curauth->ID;
		$action = 'auth_post_ajax';
		wp_enqueue_script('asp-authors', get_template_directory_uri() . '/js/authors.js', array('jquery'), filemtime(get_template_directory() . '/js/authors.js'), true);
	} else if (is_home() || is_front_page()) {
		$obj_id = null;
		$action = 'more_post_ajax';
	} else if (is_page('adminka')) {
		$taxonomy = get_queried_object();
		$obj_id = $taxonomy->term_id;
		$action = 'more_post_ajax';
		wp_enqueue_script('asp-authors', get_template_directory_uri() . '/js/authors.js', array('jquery'), filemtime(get_template_directory() . '/js/authors.js'), true);
	}

	if (isset($action))
		wp_localize_script('asp-main', 'localize', array(
			'ajaxurl' => $ajaxurl,
			'obj_id' => $obj_id,
			'action' => $action
		));
	wp_enqueue_style('asp-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');
}
add_action('wp_enqueue_scripts', 'site_scripts', 999);

<?php

namespace Core;
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class Init
{


	static $techemail;

	public function __construct()
	{

		if(str_contains(home_url(),'windowspros')) {
			$techemail = 'no-reply@asp.sale';
		} else {
			$techemail = '';
		}
		define('OPTIONS_SLUG', 'muz21');
		define('LANGUAGE_SLUG', 'muz21');
		add_theme_support('post-thumbnails');
		add_filter('intermediate_image_sizes_advanced', ['Core\Init', 'default_images'], 10, 3); // REMOVE DEFAULT IMAGE SIZES 		
		add_filter('show_admin_bar', '__return_false'); //DO NOT DISPLAY ADMIN BAR
		add_filter('send_email_change_email', '__return_false'); //DO NOT SEND EMAILS ABOUT EMAIL CHANGE
		add_action('admin_init', ['Core\Init', 'admin_access'], 1); //ADMIN ACCESS FOR ADMIN OR AJAX ONLY
		add_filter('http_request_host_is_external', '__return_true');
		add_filter('jpeg_quality', function ($arg) {
			return 95;
		}); //SET IMAGE QUALITY
		add_image_size('mini', 60, 60, true); //ADD ICON IMAGE SIZE

		add_action('template_redirect', ['Core\Init', 'redirect_attachment_to_post']); //REDIRECT ATTACHEMENTS TO POST

		//REMOVE AUTO P IN CONTENT
		//remove_filter('the_content', 'wpautop');
		//remove_filter('the_excerpt', 'wpautop');

		//REMOVE FEEDS
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'feed_links', 2);

		remove_all_actions('category_feed_link');
		remove_all_actions('post_feed_link');
		remove_all_actions('page_feed_link');
		remove_all_actions('archive_feed_link');
		remove_all_actions('do_feed');
		remove_all_actions('do_feed_rdf');
		remove_all_actions('do_feed_rss');
		remove_all_actions('do_feed_rss2');
		remove_all_actions('do_feed_atom');
		remove_all_actions('do_feed_rss2_comments');
		remove_all_actions('do_feed_atom_comments');

		add_action('category_feed_link', ['Core\Init', 'disable_feed']);
		add_action('post_feed_link', ['Core\Init', 'disable_feed']);
		add_action('page_feed_link', ['Core\Init', 'disable_feed']);
		add_action('archive_feed_link', ['Core\Init', 'disable_feed']);

		add_action('do_feed', ['Core\Init', 'disable_feed'], 1);
		add_action('do_feed_rdf', ['Core\Init', 'disable_feed'], 1);
		add_action('do_feed_rss', ['Core\Init', 'disable_feed'], 1);
		add_action('do_feed_rss2', ['Core\Init', 'disable_feed'], 1);
		add_action('do_feed_atom', ['Core\Init', 'disable_feed'], 1);
		add_action('do_feed_rss2_comments', ['Core\Init', 'disable_feed'], 1);
		add_action('do_feed_atom_comments', ['Core\Init', 'disable_feed'], 1);
		add_action('add_meta_boxes', ['Core\Init', 'add_attach_thumbs']);
		add_filter('generate_rewrite_rules', ['Core\Init', 'resources_cpt_generating_rule']);

		add_action('init', ['Core\Init', 'acf_options_pages']);
		add_action('init', ['Core\Init', 'change_author_permalinks']);
	}

	static function change_author_permalinks()
	{
		global $wp_rewrite;
		$wp_rewrite->author_base = 'author'; // Change 'member' to be the base URL you wish to use  
		$wp_rewrite->author_structure = '/' . $wp_rewrite->author_base . '/%author%';
	}
	static function resources_cpt_generating_rule($wp_rewrite)
	{
		//$rules['blogs/([^/]*)$'] = 'index.php?post_type=post&pagename=$matches[1]';
		//$rules['author/([^/]*)$'] = 'index.php?post_type=events&pagename=$matches[1]';
		$rules['events/([^/]*)$'] = 'index.php?post_type=events&pagename=$matches[1]';
		$rules['services/([^/]*)$'] = 'index.php?post_type=services&pagename=$matches[1]';
		$rules['services-type/([^/]*)$'] = 'index.php?taxonomy=services-type&term=$matches[1]';
		$rules['places/([^/]*)$'] = 'index.php?post_type=places&pagename=$matches[1]';
		$rules['([^/]*)$'] = 'index.php?pagename=$matches[1]';

		$wp_rewrite->rules = $rules + $wp_rewrite->rules;
	}



	static function acf_options_pages()
	{
		if (function_exists('acf_add_options_page')) {

			acf_add_options_page(array(
				'page_title' 	=> 'Theme Settings',
				'menu_title'	=> 'Theme Settings',
				'menu_slug' 	=> 'theme-general-settings',
				'capability'	=> 'edit_posts',
				'redirect'		=> false
			));

			acf_add_options_sub_page(array(
				'page_title' 	=> 'Author Page',
				'menu_title'	=> 'Author',
				'parent_slug'	=> 'theme-general-settings',
			));

			acf_add_options_sub_page(array(
				'page_title' 	=> 'Service Page',
				'menu_title'	=> 'Service',
				'parent_slug'	=> 'theme-general-settings',
			));

			acf_add_options_sub_page(array(
				'page_title' 	=> 'Events Page',
				'menu_title'	=> 'Events',
				'parent_slug'	=> 'theme-general-settings',
			));

			acf_add_options_sub_page(array(
				'page_title' 	=> 'Contact Forms',
				'menu_title'	=> 'Forms',
				'parent_slug'	=> 'theme-general-settings',
			));
		}
	}

	static function default_images($sizes, $image_meta, $attachment_id)
	{
		unset($sizes['1536x1536']);
		unset($sizes['2048x2048']);
		unset($sizes['medium_large']); // 768px
		return $sizes;
	}

	static function get_image_id($image_url)
	{
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
		return $attachment[0];
	}



	static function disable_feed()
	{
		http_response_code(404);
		status_header(404);
		die();
	}



	static function admin_access()
	{
		if (!current_user_can('administrator') && !wp_doing_ajax()) {
			wp_redirect(home_url());
			die();
		}
	}

	static function redirect_attachment_to_post()
	{
		if (is_attachment()) {
			global $post;
			if (empty($post)) $post = get_queried_object();
			if ($post->post_parent) {
				$link = get_permalink($post->post_parent);
				wp_redirect($link, '301');
				exit();
			} else {
				// What to do if parent post is not available
				wp_redirect(home_url(), '301');
				exit();
			}
		}
	}



	static function add_attach_thumbs()
	{

		add_meta_box('att_thumb_display', 'Attached images', ['Core\Init', 'render_attach_thumbs'], 'post');
	}

	static function render_attach_thumbs($post)
	{
		$output = '';
		$args = array(
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'post_parent' => $post->ID
		);

		$images = get_posts($args);
		foreach ($images as $image) {

			$output .= '<img src="' . wp_get_attachment_thumb_url($image->ID) . '" />';
		}

		echo $output;
	}
}

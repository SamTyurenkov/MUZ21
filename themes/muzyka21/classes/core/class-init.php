<?php

namespace Core;

class Init
{

	public function __construct()
	{
		define('OPTIONS_SLUG', 'muz21');
		define('LANGUAGE_SLUG', 'muz21');
		add_theme_support('post-thumbnails');
		add_filter('intermediate_image_sizes_advanced', ['Core\Init', 'default_images'], 10, 3); // REMOVE DEFAULT IMAGE SIZES 		
		add_filter('show_admin_bar', '__return_false'); //DO NOT DISPLAY ADMIN BAR
		add_filter('send_email_change_email', '__return_false'); //DO NOT SEND EMAILS ABOUT EMAIL CHANGE
		add_action('admin_init', ['Core\Init', 'admin_access'], 1); //ADMIN ACCESS FOR ADMIN OR AJAX ONLY
		add_filter( 'http_request_host_is_external', '__return_true' );
		add_filter('jpeg_quality', function ($arg) {
			return 95;
		}); //SET IMAGE QUALITY
		add_image_size('mini', 60, 60, true); //ADD ICON IMAGE SIZE

		add_action('template_redirect', ['Core\Init', 'redirect_attachment_to_post']); //REDIRECT ATTACHEMENTS TO POST

		add_action('init', ['Core\Init', 'stop_loading_wp_embed']);

		// Remove the REST API endpoint.
		remove_action('rest_api_init', 'wp_oembed_register_route');

		// Turn off oEmbed auto discovery.
		add_filter('embed_oembed_discover', '__return_false');

		// Don't filter oEmbed results.
		remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

		// Remove oEmbed discovery links.
		remove_action('wp_head', 'wp_oembed_add_discovery_links');

		// Remove oEmbed-specific JavaScript from the front-end and back-end.
		remove_action('wp_head', 'wp_oembed_add_host_js');

		// Remove all embeds rewrite rules.
		add_filter('rewrite_rules_array', ['Core\Init', 'disable_embeds_rewrites']);

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

	static function stop_loading_wp_embed()
	{
		if (!is_admin()) {
			wp_deregister_script('wp-embed');
		}
	}


	static function disable_embeds_rewrites($rules)
	{
		foreach ($rules as $rule => $rewrite) {
			if (false !== strpos($rewrite, 'embed=true')) {
				unset($rules[$rule]);
			}
		}
		return $rules;
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

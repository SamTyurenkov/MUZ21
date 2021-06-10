<?php

namespace Core;

class Enqueues
{
	public function __construct()
	{
		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'site_scripts'], 999);
		add_action('admin_enqueue_scripts', ['Core\Enqueues', 'back_scripts'], 999);
	}

	static function back_scripts()
	{
		wp_enqueue_style('muzyka21-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');
	}

	static function site_scripts()
	{
		global $post;
		$ajaxurl = admin_url('admin-ajax.php');
		wp_enqueue_script('muzyka21-main', get_template_directory_uri() . '/js/main.js', array('jquery'), filemtime(get_template_directory() . '/js/main.js'), true);


		wp_localize_script('muzyka21-main', 'localize', array(
			'ajaxurl' => $ajaxurl,
		));
		wp_enqueue_style('muzyka21-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');
	}
}

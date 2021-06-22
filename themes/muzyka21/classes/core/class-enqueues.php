<?php

namespace Core;

class Enqueues
{
	static $ajaxurl;
	static $uid;
	static $uname;
	static $homeurl;

	public function __construct()
	{
		Enqueues::$ajaxurl = admin_url('admin-ajax.php');
		Enqueues::$uid = wp_get_current_user()->ID;
		Enqueues::$uname = wp_get_current_user()->user_login;
		Enqueues::$homeurl = apply_filters( 'wpml_home_url', get_option( 'home' ) );


		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'site_scripts'], 999);
		add_action('admin_enqueue_scripts', ['Core\Enqueues', 'back_scripts'], 999);
		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'login_reg_scripts'], 999);
		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'author_page_scripts'], 999);
	}

	static function back_scripts()
	{
		wp_enqueue_style('muzyka21-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');
	}

	static function site_scripts()
	{
		//$ajaxurl = admin_url('admin-ajax.php');
		//$uid = wp_get_current_user()->ID;
		//$uname = wp_get_current_user()->user_login;

		wp_enqueue_script('muzyka21-main', get_template_directory_uri() . '/js/main.js', array('jquery'), filemtime(get_template_directory() . '/js/main.js'), true);


		wp_localize_script('muzyka21-main', 'localize', array(
			'ajaxurl' => Enqueues::$ajaxurl,
			'homeurl' => Enqueues::$homeurl,
			'uid' => Enqueues::$uid,
			'uname' => Enqueues::$uname
		));
		wp_enqueue_style('muzyka21-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');
	}

	static function login_reg_scripts() {

		if (!is_user_logged_in()) {
			wp_enqueue_script('muzyka21-notlogged', get_template_directory_uri() . '/js/login-reg/notlogged.js', array('jquery'), filemtime(get_template_directory() . '/js/login-reg/notlogged.js'), true);
			wp_localize_script('muzyka21-notlogged', 'localize', array(
				'ajaxurl' => Enqueues::$ajaxurl,
				'homeurl' => Enqueues::$homeurl,
			));
		} 
	}

	static function author_page_scripts() {

		if (is_author() && get_user_meta(Enqueues::$uid, 'valimail', true) == false) {
			wp_enqueue_script('muzyka21-emailvalidation', get_template_directory_uri() . '/js/author-page/emailvalidation.js', array('jquery'), filemtime(get_template_directory() . '/js/author-page/emailvalidation.js'), true);
			wp_localize_script('muzyka21-emailvalidation', 'localize', array(
				'ajaxurl' => Enqueues::$ajaxurl,
				'homeurl' => Enqueues::$homeurl,
				'uid' => Enqueues::$uid,
				'uname' => Enqueues::$uname
			));
		}
	}
}

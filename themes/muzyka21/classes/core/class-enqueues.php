<?php

namespace Core;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class Enqueues
{
	static $ajaxurl;
	static $uid;
	static $aid;
	static $uname;
	static $homeurl;
	static $postid;

	public function __construct()
	{

		Enqueues::$ajaxurl = admin_url('admin-ajax.php');
		Enqueues::$uid = wp_get_current_user()->ID;
		Enqueues::$uname = wp_get_current_user()->user_login;
		Enqueues::$homeurl = apply_filters('wpml_home_url', get_option('home'));


		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'site_scripts'], 999);
		add_action('admin_enqueue_scripts', ['Core\Enqueues', 'back_scripts'], 999);
		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'login_reg_scripts'], 999);
		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'author_page_scripts'], 999);
		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'payment_scripts'], 999);
	}

	static function back_scripts()
	{
		wp_enqueue_script('splide', get_template_directory_uri() . '/js/splide.min.js', array(), filemtime(get_template_directory() . '/js/splide.min.js'), true);
		wp_enqueue_script('muzyka21-main', get_template_directory_uri() . '/js/main.js', array('jquery'), filemtime(get_template_directory() . '/js/main.js'), true);
		wp_enqueue_style('muzyka21-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');
	}

	static function site_scripts()
	{
		//$ajaxurl = admin_url('admin-ajax.php');
		//$uid = wp_get_current_user()->ID;
		//$uname = wp_get_current_user()->user_login;

		wp_enqueue_script('splide', get_template_directory_uri() . '/js/splide.min.js', array(), filemtime(get_template_directory() . '/js/splide.min.js'), true);
		wp_enqueue_script('muzyka21-main', get_template_directory_uri() . '/js/main.js', array('jquery'), filemtime(get_template_directory() . '/js/main.js'), true);

		wp_localize_script('muzyka21-main', 'localize', array(
			'ajaxurl' => Enqueues::$ajaxurl,
			'homeurl' => Enqueues::$homeurl,
			'uid' => Enqueues::$uid,
			'uname' => Enqueues::$uname
		));
		wp_enqueue_style('muzyka21-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');
	}

	static function payment_scripts()
	{

		if (is_singular('events')) {

			Enqueues::$postid = get_the_ID();

			wp_enqueue_script('prepayment-frame', get_template_directory_uri() . '/js/prepayment-frame.js', array('jquery'), filemtime(get_template_directory() . '/js/prepayment-frame.js'), true);
			wp_localize_script('prepayment-frame', 'localize_prepayment', array(
				'ajaxurl' => Enqueues::$ajaxurl,
				'postid' => Enqueues::$postid,
			));
		}
	}

	static function login_reg_scripts()
	{

		if (!is_user_logged_in()) {
			wp_enqueue_script('muzyka21-notlogged', get_template_directory_uri() . '/js/login-reg/notlogged.js', array('jquery'), filemtime(get_template_directory() . '/js/login-reg/notlogged.js'), true);
			wp_localize_script('muzyka21-notlogged', 'localize', array(
				'ajaxurl' => Enqueues::$ajaxurl,
				'homeurl' => Enqueues::$homeurl,
			));
		}
	}

	static function author_page_scripts()
	{
		if (is_author()) :
			Enqueues::$aid = get_queried_object()->ID;


			if (Enqueues::$uid == Enqueues::$aid || current_user_can('editor' || 'administrator')) {
				wp_enqueue_script('muzyka21-author_page', get_template_directory_uri() . '/js/author-page/author_page.js', array('jquery'), filemtime(get_template_directory() . '/js/author-page/author_page.js'), true);
				wp_localize_script('muzyka21-author_page', 'localize_author', array(
					'ajaxurl' => Enqueues::$ajaxurl,
					'homeurl' => Enqueues::$homeurl,
					'uid' => Enqueues::$uid,
					'uname' => Enqueues::$uname,
					'aid' => Enqueues::$aid,
				));
			}
			if (current_user_can('administrator')) {
				wp_enqueue_script('admin-author', get_template_directory_uri() . '/js/admin-stuff/admin-author.js', array('jquery'), filemtime(get_template_directory() . '/js/admin-stuff/admin-author.js'), true);
				wp_localize_script('admin-author', 'localize_admin_author', array(
					'ajaxurl' => Enqueues::$ajaxurl,
					'aid' => Enqueues::$aid,
				));
			}
		endif;
	}
}

<?php

namespace Core;

class Enqueues
{
	public function __construct()
	{
		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'site_scripts'], 999);
		add_action('admin_enqueue_scripts', ['Core\Enqueues', 'back_scripts'], 999);
		add_action('wp_enqueue_scripts', ['Core\Enqueues', 'login_reg_scripts'], 999);
	}

	static function back_scripts()
	{
		wp_enqueue_style('muzyka21-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');
	}

	static function site_scripts()
	{
		$ajaxurl = admin_url('admin-ajax.php');
		$uid = wp_get_current_user()->ID;
		$uname = wp_get_current_user()->user_login;

		wp_enqueue_script('muzyka21-main', get_template_directory_uri() . '/js/main.js', array('jquery'), filemtime(get_template_directory() . '/js/main.js'), true);


		wp_localize_script('muzyka21-main', 'localize', array(
			'ajaxurl' => $ajaxurl,
			'uid' => $uid,
			'uname' => $uname
		));
		wp_enqueue_style('muzyka21-main', get_template_directory_uri() . '/css/main.css', array(), filemtime(get_template_directory() . '/css/main.css'), 'all');
	}

	static function login_reg_scripts() {

		$ajaxurl = admin_url('admin-ajax.php');
		$uid = wp_get_current_user()->ID; 
		$uname = wp_get_current_user()->user_login;

		if (!is_user_logged_in()) {
			wp_enqueue_script('muzyka21-notlogged', get_template_directory_uri() . '/js/login-reg/notlogged.js', array('jquery'), filemtime(get_template_directory() . '/js/login-reg/notlogged.js'), true);
			wp_localize_script('muzyka21-notlogged', 'localize', array(
				'ajaxurl' => $ajaxurl,
			));
		} else if (get_user_meta($uid, 'valimail', true) == false) {
			wp_enqueue_script('muzyka21-emailvalidation', get_template_directory_uri() . '/js/login-reg/emailvalidation.js', array('jquery'), filemtime(get_template_directory() . '/js/login-reg/emailvalidation.js'), true);
			wp_localize_script('muzyka21-emailvalidation', 'localize', array(
				'ajaxurl' => $ajaxurl,
				'uid' => $uid,
				'uname' => $uname
			));
		}
	}
}

<?php
if(!defined('ABSPATH')) {
  die('You are not allowed to call this page directly.');
}
remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );
add_theme_support( 'post-thumbnails' );

//add_filter( 'http_request_host_is_external', '__return_true' );
require_once('core/menu.php'); //MENU
require_once('core/enqueues.php'); //SCRIPTS ENQUEUE
require_once('core/init.php'); //INITIALIZE WP WITH CUSTOM FUNCTIONS
require_once('core/ajaxcalls.php'); //AJAX FUNCTIONS
require_once('core/helpers.php'); //MOBILE CHECK, LANGUAGE CHECK, COOKIES
require_once('core/authors.php'); //AUTHORS AND THEIR META
require_once('core/propeditor.php'); //EDITING PROPERTIES
require_once('core/custom-ajax-auth.php'); //CUSTOM AUTHORIZATION ON FRONTEND


//CRON DELETE USERS
if (!wp_next_scheduled( 'my_weeklyClearOut' ))
wp_schedule_event(time(), 'weekly', 'my_weeklyClearOut');

function my_clearOldUsers() {
	require_once(ABSPATH.'wp-admin/includes/user.php');
    global $wpdb;

    $users = $wpdb->get_results("SELECT ID FROM wp_users WHERE datediff(now(), user_registered) > 30 AND ID NOT IN (SELECT DISTINCT post_author FROM wp_posts ) AND ID NOT IN (1) LIMIT 20",ARRAY_N);

    if ($users) {
        foreach ($users as $user_id) {
			
            wp_delete_user($user_id[0]);
        }
    }
}

add_action('my_weeklyClearOut', 'my_clearOldUsers');
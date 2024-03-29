<?php
spl_autoload_register( function($classname) {

    $parts      = explode('\\', $classname);
    $class      = 'class-' . strtolower( array_pop($parts) );
    $folders    = strtolower( implode(DIRECTORY_SEPARATOR, $parts) );
    $classpath     = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $folders . DIRECTORY_SEPARATOR . $class . '.php';
    
    if ( file_exists( $classpath) ) {
        include_once $classpath;
    }
   
} );


    new Core\Init();
    new Core\Enqueues();
    new Core\Auth();
    new Core\Menu();
    new Core\ACFBlocks();
    new Core\Authors();
    new Core\Uploads();
    $gplaces = new Core\Places();
    $gevents = new Core\Events();
    $gservices = new Core\Services();
    $gpurchases = new Core\Purchases();




//CRON DELETE USERS
//if (!wp_next_scheduled( 'my_weeklyClearOut' ))
//wp_schedule_event(time(), 'weekly', 'my_weeklyClearOut');

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

add_filter('acf/update_value/type=date_time_picker', 'my_update_value_date_time_picker', 10, 3);

function my_update_value_date_time_picker( $value, $post_id, $field ) {
    return strtotime( $value );
}
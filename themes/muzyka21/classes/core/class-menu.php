<?php

namespace Core;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
class Menu
{

    public function __construct()
    {
        add_theme_support('menus');

        add_action('init', ['Core\Menu', 'register_menus']);
        add_filter('wp_nav_menu_items', ['Core\Menu', 'avatar_in_menu'], 10, 2);
    }

    static function avatar_in_menu($nav, $args)
    {


        if (strpos($args->menu->slug,'personal') !== false) {

            $uid = get_current_user_id();

            if ($uid > 0) {
                $avaversion = get_the_author_meta('avaversion', $uid);
                return str_replace('<a href="#">', '<a href="#"><img src="' . get_avatar_url($uid, array('size' => 30,)) . '?v=' . $avaversion . '">', $nav);
            } else {
                return str_replace('<a href="#">', '<a href="#"><img src="' . content_url() . '/themes/muzyka21/images/user/avatar.svg">', $nav);
            }
        }

        return $nav;
    }


    static function register_menus()
    {
        register_nav_menus(
            array(
                'topbar' => __('Topbar'),
                'personal' => __('Personal'),
                'footer' => __('Footer'),
                'mobile' => 'Mobile'
            )
        );
    }
}

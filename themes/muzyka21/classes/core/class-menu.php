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
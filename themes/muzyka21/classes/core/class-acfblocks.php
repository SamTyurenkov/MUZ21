<?php

namespace Core;
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class ACFBlocks
{

    public function __construct()
    {
        add_action('acf/init', ['Core\ACFBlocks', 'acf_init']);
        
    }


    static function acf_init()
    {
        // check function exists
        if (function_exists('acf_register_block')) {
            // register a gutenberg slider block
            acf_register_block(array(
                'name' => 'muzbanner',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Homepage Banner'),
                'description' => __('Homepage Banner'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('banner'),
            ));

            acf_register_block(array(
                'name' => 'muzfeatures',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('General Features List'),
                'description' => __('General Features List'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('features'),
            ));

            acf_register_block(array(
                'name' => 'muzallplaces',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('General List All Places'),
                'description' => __('General List All Places'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('places'),
            ));

            acf_register_block(array(
                'name' => 'muzwavesevents',
                'enqueue_assets' => ['Core\ACFBlocks', 'muzwavesevents_assets'],
                'title' => __('General Events in Waves'),
                'description' => __('General Events in Waves'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('waves', 'events'),
            ));

            acf_register_block(array(
                'name' => 'muzsidebanner',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('General Side Banner'),
                'description' => __('General Side Banner'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('waves', 'banner'),
            ));

            acf_register_block(array(
                'name' => 'service-mainbanner',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Service Main Banner'),
                'description' => __('Service Main Banner'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('service', 'banner'),
            ));

            acf_register_block(array(
                'name' => 'services-all-extended',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Services All Extended'),
                'description' => __('Services All Extended'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('services', 'list'),
            ));

            acf_register_block(array(
                'name' => 'place-residents',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Muz Place Residents'),
                'description' => __('Muz Place Residents'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('place', 'banner', 'residents'),
            ));

            acf_register_block(array(
                'name' => 'places-all-extended',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Places All Extended'),
                'description' => __('Places All Extended'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('places', 'list'),
            ));

            acf_register_block(array(
                'name' => 'general-shapebanner',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Shape Banner'),
                'description' => __('Shape Banner'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('shape', 'banner'),
            ));

            acf_register_block(array(
                'name' => 'general-shapebanner-2',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Shape Banner 2'),
                'description' => __('Shape Banner 2'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('shape', 'banner'),
            ));

            acf_register_block(array(
                'name' => 'general-contact-form',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('General Contact Form'),
                'description' => __('General Contact Form'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('contact', 'form'),
            ));
        }
    }

    static function block_render_callback($block, $content = '', $is_preview = false, $post_id = 0)
    {
        // convert name ("acf/testimonial") into path friendly slug ("testimonial")
        $slug = str_replace('acf/', '', $block['name']);
        set_query_var('post_id', $post_id);
        // include a template part from within the "template-parts/block" folder
        if (file_exists(get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php"))) {
            include get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php");
        }
    }

    static function muzwavesevents_assets()
    {
        wp_enqueue_script('splide', get_template_directory_uri() . '/js/splide.min.js', array(), filemtime(get_template_directory() . '/js/splide.min.js'), true);
        wp_enqueue_script('muzwavesevents', get_template_directory_uri() . '/js/gutenberg-blocks/muzwavesevents.js', array('jquery', 'splide'), filemtime(get_template_directory() . '/js/gutenberg-blocks/muzwavesevents.js'), true);
    }
}

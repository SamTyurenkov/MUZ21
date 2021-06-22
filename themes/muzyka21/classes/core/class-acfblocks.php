<?php

namespace Core;

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
                'title' => __('Muz Banner'),
                'description' => __('Muz Banner'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('banner'),
            ));

            acf_register_block(array(
                'name' => 'muzfeatures',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Muz Features'),
                'description' => __('Muz Features'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('features'),
            ));

            acf_register_block(array(
                'name' => 'muzallplaces',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Muz All Places'),
                'description' => __('Muz All Places'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('places'),
            ));

            acf_register_block(array(
                'name' => 'muzwavesevents',
                'enqueue_assets' => ['Core\ACFBlocks','muzwavesevents_assets'],
                'title' => __('Muz Waves Events'),
                'description' => __('Muz Waves Events'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('waves','events'),
            ));

            acf_register_block(array(
                'name' => 'muzsidebanner',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Muz Side Banner'),
                'description' => __('Muz Side Banner'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('waves','banner'),
            ));

            acf_register_block(array(
                'name' => 'service-optionpicker',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Muz Service Option Picker'),
                'description' => __('Muz Service Option Picker'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('service','banner'),
            ));

            acf_register_block(array(
                'name' => 'place-residents',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Muz Place Residents'),
                'description' => __('Muz Place Residents'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('place','banner','residents'),
            ));

            acf_register_block(array(
                'name' => 'places-all-extended',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Places All Extended'),
                'description' => __('Places All Extended'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('places','list'),
            ));

            acf_register_block(array(
                'name' => 'general-shapebanner',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Shape Banner'),
                'description' => __('Shape Banner'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('shape','banner'),
            ));

        }
    }

    static function block_render_callback($block)
    {
        // convert name ("acf/testimonial") into path friendly slug ("testimonial")
        $slug = str_replace('acf/', '', $block['name']);

        // include a template part from within the "template-parts/block" folder
        if (file_exists(get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php"))) {
            include get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php");
        }
    }

    static function muzwavesevents_assets()
    {
        wp_enqueue_script('splide', get_template_directory_uri() . '/js/splide.min.js', array(), filemtime(get_template_directory() . '/js/splide.min.js'), true);
        wp_enqueue_script('muzwavesevents', get_template_directory_uri() . '/js/gutenberg-blocks/muzwavesevents.js', array('jquery','splide'), filemtime(get_template_directory() . '/js/gutenberg-blocks/muzwavesevents.js'), true);
    }
}

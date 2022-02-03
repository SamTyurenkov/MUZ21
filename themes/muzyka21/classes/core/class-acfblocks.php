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
                'name' => 'general-wavefix',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('General Wave Fix'),
                'description' => __('General Wave Fix'),
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
                'name' => 'service-price',
                'enqueue_assets' => ['Core\ACFBlocks', 'service_price_assets'],
                'title' => __('Service Price'),
                'description' => __('Service Price'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('service', 'banner', 'price'),
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
                'title' => __('Place Residents'),
                'description' => __('Place Residents'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('place', 'banner', 'residents'),
            ));

            acf_register_block(array(
                'name' => 'place-contact',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Place Contact'),
                'description' => __('Place Contact'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('place', 'banner', 'contact'),
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
                'name' => 'general-gallery',
                'enqueue_assets' => ['Core\ACFBlocks', 'general_gallery_assets'],
                'title' => __('General Gallery'),
                'description' => __('General Gallery'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('shape', 'gallery', 'image'),
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
                'enqueue_assets' => ['Core\ACFBlocks', 'general_contact_form_assets'],
                'title' => __('General Contact Form'),
                'description' => __('General Contact Form'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('contact', 'form'),
            ));


            acf_register_block(array(
                'name' => 'event-banner',
                //'enqueue_assets' => 'muzbanner_assets',
                'title' => __('Event Banner'),
                'description' => __('Event Banner'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('banner', 'event'),
            ));

            acf_register_block(array(
                'name' => 'event-price',
                'enqueue_assets' => ['Core\ACFBlocks', 'event_price_assets'],
                'title' => __('Event Price'),
                'description' => __('Event Price'),
                'render_callback' => ['Core\ACFBlocks', 'block_render_callback'],
                'category' => 'formatting',
                'icon' => 'admin-comments',
                'keywords' => array('price', 'event', 'buy'),
            ));
        }
    }

    private static function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

    static function block_render_callback($block, $content = '', $is_preview = false, $post_id = 0)
    {
        // convert name ("acf/testimonial") into path friendly slug ("testimonial")
        $slug = str_replace('acf/', '', $block['name']);
        // error_log($slug);
        // error_log(ACFBlocks::convert(memory_get_usage(true)));
        set_query_var('post_id', $post_id);
        // include a template part from within the "template-parts/block" folder
        if (file_exists(get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php"))) {
            include get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php");
        }
    }

    static function muzwavesevents_assets()
    {
        wp_enqueue_script('muzwavesevents', get_template_directory_uri() . '/js/gutenberg-blocks/muzwavesevents.js', array('jquery', 'splide'), filemtime(get_template_directory() . '/js/gutenberg-blocks/muzwavesevents.js'), true);
    }

    static function general_gallery_assets()
    {
        wp_enqueue_script('general-gallery', get_template_directory_uri() . '/js/gutenberg-blocks/general-gallery.js', array('jquery'), filemtime(get_template_directory() . '/js/gutenberg-blocks/general-gallery.js'), true);
    }

    static function general_contact_form_assets()
    {
        wp_enqueue_script('general-contact', get_template_directory_uri() . '/js/gutenberg-blocks/general-contact-form.js', array('jquery'), filemtime(get_template_directory() . '/js/gutenberg-blocks/general-contact-form.js'), true);
    }


    static function event_price_assets()
    {
        wp_enqueue_script('event-price', get_template_directory_uri() . '/js/gutenberg-blocks/event-price.js', array('jquery'), filemtime(get_template_directory() . '/js/gutenberg-blocks/event-price.js'), true);
    }
    static function service_price_assets()
    {
        wp_enqueue_script('service-price', get_template_directory_uri() . '/js/gutenberg-blocks/service-price.js', array('jquery'), filemtime(get_template_directory() . '/js/gutenberg-blocks/service-price.js'), true);
    }
}

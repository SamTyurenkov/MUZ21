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

    static function muzbanner_assets()
    {
        //wp_enqueue_script('muzbanner', get_template_directory_uri() . '/assets/gutenbergslider.js', array(), filemtime(get_template_directory() . '/assets/scripts/js'), true);
    }
}

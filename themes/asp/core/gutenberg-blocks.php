<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

add_action('init', function () {
    wp_register_script('asp-sidebanner', get_template_directory_uri() . '/js/gutenberg-blocks/sidebanner.js', array('jquery', 'wp-editor','wp-blocks','wp-i18n','wp-element'), filemtime(get_template_directory() . '/js/gutenberg-blocks/sidebanner.js'), true);
    wp_register_script('asp-justbanner', get_template_directory_uri() . '/js/gutenberg-blocks/justbanner.js', array('jquery', 'wp-editor','wp-blocks','wp-i18n','wp-element'), filemtime(get_template_directory() . '/js/gutenberg-blocks/justbanner.js'), true);

    // wp_register_script('asp-postlist', get_template_directory_uri() . '/js/gutenberg-blocks/postlist.js', array('jquery', 'wp-editor','wp-blocks','wp-i18n','wp-element'), filemtime(get_template_directory() . '/js/gutenberg-blocks/postlist.js'), true);

    register_block_type('asp/sidebanner', [
        'editor_script' => 'asp-sidebanner',
        'render_callback' => 'blocks_render_callback',
        'attributes' => [
            'blockname' => [
                'type' => 'string',
                'default' => 'sidebanner'
            ],
            'title' => [
                'type' => 'string'
            ],
            'subtitle' => [
                'type' => 'string'
            ],
            'mediaId'=> [
                'type'=> 'number',
                'default'=> 0
            ],
            'mediaUrl'=> [
                'type'=> 'string',
                'default'=> ''
            ]
        ]
    ]);
    register_block_type('asp/justbanner', [
        'editor_script' => 'asp-justbanner',
    ]);
    // register_block_type('asp/postlist', [
    //     'editor_script' => 'asp-postlist',
    //     'render_callback' => 'blocks_render_callback',
    //     'attributes' => [
    //         'blockname' => [
    //             'type' => 'string',
    //             'default' => 'postlist'
    //         ],
    //         'title' => [
    //             'type' => 'string',
    //             'default' => ''
    //         ],
    //         'subtitle' => [
    //             'type' => 'string',
    //             'default' => ''
    //         ],
    //         'postlist' => [
    //             'type' => 'array',
    //             'default' => []
    //         ]
    //     ]
    // ]);
});



function blocks_render_callback($attr, $content)
{
    // return the block's output here
    $slug = $attr['blockname'];
    if (file_exists(get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php"))) {
        error_log($slug);
        set_query_var('block-attr', $attr);
        include get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php");
    }
}

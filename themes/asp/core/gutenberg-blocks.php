<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action('init', function () {
    register_block_type('asp/sidebanner', [
        'editor_script' => 'sidebanner',
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
			'image' => [
				'type' => 'image'
			]
		]
    ]);
});



function blocks_render_callback($attr, $content)
{
    // return the block's output here
    
    $slug = $attr['blockname'];
    if(file_exists(get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php"))) {
        set_query_var('block-attr',$attr);
        include get_theme_file_path("/templates/gutenberg-blocks/block-{$slug}.php");
    }
}

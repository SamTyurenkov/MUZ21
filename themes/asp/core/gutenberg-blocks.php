<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action('init', function () {
    wp_register_script('asp-sidebanner', get_template_directory_uri() . '/js/gutenberg-blocks/sidebanner.js', array('jquery'), filemtime(get_template_directory() . '/js/gutenberg-blocks/sidebanner.js'), true);

    register_block_type('asp/sidebanner', [
        'editor_script' => 'asp-sidebanner',
        'render_callback' => 'blocks_render_callback',
        'attributes' => [
            'blockname' => 'sidebanner',
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

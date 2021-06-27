<?php

namespace Core;
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class Places
{
	public function __construct()
	{
		add_action('init', ['Core\Places', 'post_type_places']);
		add_action('init', ['Core\Places', 'register_post_template']);
	}

	//ADD Place POST TYPE

	static function post_type_places()
	{
		register_post_type(
			'places',
			array(
				'label' => null,
				'labels' => array(
					'name'               => 'Places', // основное название для типа записи
					'singular_name'      => 'Place', // название для одной записи этого типа
					'add_new'            => 'Add Place', // для добавления новой записи
					'add_new_item'       => 'Adding Place', // заголовка у вновь создаваемой записи в админ-панели.
					'edit_item'          => 'Edit Place', // для редактирования типа записи
					'new_item'           => 'New Place', // текст новой записи
					'view_item'          => 'View Place', // для просмотра записи этого типа.
					'search_items'       => 'Search Place', // для поиска по этим типам записи
					'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
					'not_found_in_trash' => 'Not found in trash', // если не было найдено в корзине
					'menu_name'          => 'Places', // название меню
				),
				'public'              => true,
				'publicly_queryable'  => null, // зависит от public
				'has_archive' => true,
				'exclude_from_search' => true, // зависит от public
				'show_ui'             => null, // зависит от public
				'show_in_menu'        => null, // показывать ли в меню адмнки
				'show_in_admin_bar'   => null, // по умолчанию значение show_in_menu
				'show_in_nav_menus'   => null, // зависит от public
				'show_in_rest'        => true, // добавить в REST API. C WP 4.7
				'rest_base'           => null, // $post_type. C WP 4.7
				'menu_icon'           => null,
				'menu_position' => 6,
				'rewrite' => array(
					'slug' => 'places',
					'with_front' => FALSE,
				),
				'supports' => array(
					'thumbnail',
					'custom-fields',
					'title',
					'author',
					'editor',
					'excerpt'
				)
			)
		);
	}

	static function register_post_template()
    {
        $post_type_object = get_post_type_object('places');
        $post_type_object->template = array(
            array('acf/muzsidebanner'),
			array('acf/muzfeatures'),
			array('acf/place-residents'),
			array('acf/muzwavesevents')
        );
    }

}
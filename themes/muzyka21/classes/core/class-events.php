<?php

namespace Core;

class Events
{
	public function __construct()
	{
		add_action('init', ['Core\Events', 'post_type_events']);
	}

	//ADD Event POST TYPE

	static function post_type_Events()
	{
		register_post_type(
			'events',
			array(
				'label' => null,
				'labels' => array(
					'name'               => 'Events', // основное название для типа записи
					'singular_name'      => 'Event', // название для одной записи этого типа
					'add_new'            => 'Add Event', // для добавления новой записи
					'add_new_item'       => 'Adding Event', // заголовка у вновь создаваемой записи в админ-панели.
					'edit_item'          => 'Edit Event', // для редактирования типа записи
					'new_item'           => 'New Event', // текст новой записи
					'view_item'          => 'View Event', // для просмотра записи этого типа.
					'search_items'       => 'Search Event', // для поиска по этим типам записи
					'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
					'not_found_in_trash' => 'Not found in trash', // если не было найдено в корзине
					'menu_name'          => 'Events', // название меню
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
					'slug' => 'events',
					'with_front' => FALSE,
				),
				'supports' => array(
					'thumbnail',
					'custom-fields',
					'title',
					'author',
					'editor'
				)
			)
		);
	}

}
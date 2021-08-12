<?php

namespace Core;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class Services
{
	public function __construct()
	{
		add_action('init', ['Core\Services', 'post_type_services']);
		add_action('init', ['Core\Services', 'taxonomy_type_services_type']);
		add_action('init', ['Core\Services', 'register_post_template']);
	}

	//ADD Service POST TYPE

	static function post_type_services()
	{
		register_post_type(
			'services',
			array(
				'label' => null,
				'labels' => array(
					'name'               => 'Services', // основное название для типа записи
					'singular_name'      => 'Service', // название для одной записи этого типа
					'add_new'            => 'Add Service', // для добавления новой записи
					'add_new_item'       => 'Adding Service', // заголовка у вновь создаваемой записи в админ-панели.
					'edit_item'          => 'Edit Service', // для редактирования типа записи
					'new_item'           => 'New Service', // текст новой записи
					'view_item'          => 'View Service', // для просмотра записи этого типа.
					'search_items'       => 'Search Service', // для поиска по этим типам записи
					'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
					'not_found_in_trash' => 'Not found in trash', // если не было найдено в корзине
					'menu_name'          => 'Services', // название меню
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
					'slug' => 'services',
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

	static function taxonomy_type_services_type()
	{

		$worklabels = array(
			'name'              => __('Services Type', 'muz21'),
			'singular_name'     => __('Type', 'muz21'),
			'search_items'      => __('Search Services', 'muz21'),
			'all_items'         => __('All Type', 'muz21'),
			'parent_item'       => __('Parent Type', 'muz21'),
			'parent_item_colon' => __('Parent Type:', 'muz21'),
			'edit_item'         => __('Edit Type', 'muz21'),
			'update_item'       => __('Update Type', 'muz21'),
			'add_new_item'      => __('Add New Type', 'muz21'),
			'new_item_name'     => __('New Type Name', 'muz21'),
		);

		register_taxonomy('services-type', array('services'), array(
			'hierarchical' => true,
			'labels'       => $worklabels,
			'show_ui'      => true,
			'query_var'    => true,
			'show_in_rest' => true,
			'rewrite' => array(
				'slug' => 'services-type',
				'with_front' => FALSE,
			)
		));
	}

	static function register_post_template()
	{
		$post_type_object = get_post_type_object('services');
		$post_type_object->template = array(
			array('acf/service-mainbanner'),
			array('acf/muzfeatures'),
			array('acf/muzallplaces'),
			array('acf/service-price'),
			array('acf/general-contact-form')
		);
	}
}

<?php

namespace Core;

use DateTime;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class Events
{
	public function __construct()
	{
		add_action('init', ['Core\Events', 'post_type_events']);
		add_action('init', ['Core\Events', 'register_post_template']);

		add_action('wp_ajax_updateticketinfo', ['Core\Events', 'updateticketinfo']);
		add_action('wp_ajax_createnewticket', ['Core\Events', 'createnewticket']);
		add_action('wp_ajax_deleteticket', ['Core\Events', 'deleteticket']);
		add_action('wp_ajax_createevent', ['Core\Events', 'createevent']);
		add_action('wp_ajax_updateeventinfo', ['Core\Events', 'updateeventinfo']);
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
					'editor',
					'excerpt'
				)
			)
		);
	}

	static function register_post_template()
	{
		$post_type_object = get_post_type_object('events');
		$post_type_object->template = array(
			array('acf/event-banner'),
			array('acf/event-price'),
		);
	}

	static function createnewticket()
	{
		if (!current_user_can('edit_post', $_POST['postid'])) return;
		if (wp_verify_nonce($_POST['nonce'], '_editor')) {
			$postid = filter_var($_POST['postid'], FILTER_SANITIZE_NUMBER_INT);
			$prices = get_field('prices', $postid);

			$prices[] = array(
				'option_name' => null,
				'option_price' => null,
				'option_description' => null
			);
			\update_field('prices', $prices, $postid);

			$response['response'] = 'SUCCESS';
			echo json_encode($response);
			die();
		} else {
			$response['response'] = 'ERROR';
			$response['error'] = 'Обновите страницу и попробуйте снова';
			echo json_encode($response);
			die();
		}
	}

	static function updateticketinfo()
	{
		if (!current_user_can('edit_post', $_POST['postid'])) return;
		if (wp_verify_nonce($_POST['nonce'], '_editor')) {
			$postid = filter_var($_POST['postid'], FILTER_SANITIZE_NUMBER_INT);
			$ticketid = filter_var($_POST['ticketid'], FILTER_SANITIZE_NUMBER_INT);
			$field = sanitize_text_field($_POST['field']);
			$value = sanitize_text_field($_POST['value']);

			if ($field == 'option_price') {
				$value = intval($value);
			}

			$prices = get_field('prices', $postid);

			$prices[$ticketid][$field] = $value;
			\update_field('prices', $prices, $postid);

			$response['response'] = 'SUCCESS';
			echo json_encode($response);
			die();
		} else {
			$response['response'] = 'ERROR';
			$response['error'] = 'Обновите страницу и попробуйте снова';
			echo json_encode($response);
			die();
		}
	}

	static function deleteticket()
	{
		if (!current_user_can('edit_post', $_POST['postid'])) return;
		if (wp_verify_nonce($_POST['nonce'], '_editor')) {
			$postid = filter_var($_POST['postid'], FILTER_SANITIZE_NUMBER_INT);
			$ticketid = filter_var($_POST['ticketid'], FILTER_SANITIZE_NUMBER_INT);

			$prices = get_field('prices', $postid);
			unset($prices[$ticketid]);

			\update_field('prices', $prices, $postid);
			$response['response'] = 'SUCCESS';
			echo json_encode($response);
			die();
		} else {
			$response['response'] = 'ERROR';
			$response['error'] = 'Обновите страницу и попробуйте снова';
			echo json_encode($response);
			die();
		}
	}

	static function createevent()
	{
		if (!current_user_can('administrator') && get_current_user_id() != $_POST['aid']) return;
		if (wp_verify_nonce($_POST['nonce'], '_editauthmeta')) {
			global $sitepress;
			$tempdate = new \DateTime();


			$post_content = '<!-- wp:acf/event-banner {
			"id": "block_60f312ca4e573",
			"name": "acf\/event-banner",
			"align": "",
			"mode": "preview"
		} /-->
		
		<!-- wp:acf/event-price {
			"id": "block_60f312cf4e574",
			"name": "acf\/event-price",
			"data": {
				"title": "",
				"_title": "field_60f1f42c453c8",
				"subtitle": "",
				"_subtitle": "field_60f1f431453c9"
			},
			"align": "",
			"mode": "preview"
		} /-->';


			$my_post = array(
				'post_type' => 'events',
				'post_title'    => sanitize_text_field($_POST['meta']),
				'post_content'  => $post_content,
				'post_status'   => "draft",
				'post_author'   => intval($_POST['aid']),
				'meta_input' => array(
					'date_start' => $tempdate->format('Y-m-d H:i:s'),
					'_date_start' => 'field_60c6622c76ae7' //ACF field value
				)
			);

			$post_id = wp_insert_post($my_post);
			$def_trid = $sitepress->get_element_trid($post_id);

			$languages = apply_filters('wpml_active_languages', NULL, 'orderby=id&order=desc');

			foreach ($languages as $language) {
				if ($language['code'] != \ICL_LANGUAGE_CODE) {
					$translated_id = wp_insert_post($my_post);
					$sitepress->set_element_language_details($translated_id, 'post_events', $def_trid, $language['code']);
				}
			}

			if (is_numeric($post_id)) {
				$response['response'] = 'SUCCESS';
				$response['info'] = $post_id;
				echo json_encode($response);
				die();
			}
		} else {
			$response['response'] = 'ERROR';
			$response['error'] = 'Обновите страницу и попробуйте снова';
			echo json_encode($response);
			die();
		}
	}

	static function updateeventinfo()
	{
		if (!current_user_can('edit_post', $_POST['postid'])) return;
		if (wp_verify_nonce($_POST['nonce'], '_editor')) {
			$postid = filter_var($_POST['postid'], FILTER_SANITIZE_NUMBER_INT);
			$field = sanitize_text_field($_POST['field']);
			$value = sanitize_text_field($_POST['value']);

			switch ($field) {

				case 'event_place':

					\update_field('place', intval($value), $postid);
					break;

				case 'event_date_start':
					$date = new DateTime($value);
					\update_field('date_start', $date->format('Y-m-d H:i:s'), $postid);
					break;

				case 'event_date_end':
					$date = new DateTime($value);
					\update_field('date_end', $date->format('Y-m-d H:i:s'), $postid);
					break;

				case 'event_title':
					$array = array(
						'ID'           => intval($postid),
						'post_title' => strip_tags($value),
					);
					wp_update_post($array);
					break;

				case 'event_description':
					$array = array(
						'ID'           => intval($postid),
						'post_excerpt' => strip_tags($value),
					);
					wp_update_post($array);
					break;
			}

			$response['response'] = 'SUCCESS';
			echo json_encode($response);
			die();
		} else {
			$response['response'] = 'ERROR';
			$response['error'] = 'Обновите страницу и попробуйте снова';
			echo json_encode($response);
			die();
		}
	}
}

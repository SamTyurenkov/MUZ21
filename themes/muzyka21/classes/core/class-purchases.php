<?php

namespace Core;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class Purchases
{
	public function __construct()
	{
		add_action('init', ['Core\Purchases', 'post_type_purchases']);
		add_action('init', ['Core\Purchases', 'taxonomy_type_purchase_status']);
		add_action('wp_ajax_prepayment', ['Core\Purchases', 'prepayment']);

		add_action('rest_api_init', function () {
			register_rest_route('custom', '/purchases/alphabank/', array(
				'methods' => 'GET',
				'callback' => ['Core\Purchases', 'completepurchase'],
				'permission_callback' => '__return_true'
			));
		});
	}

	//ADD PURCHASE POST TYPE

	public static function prepayment()
	{
		if (wp_verify_nonce($_POST['nonce'], '_payments')) {

			$email = sanitize_email($_POST['email']);
			$phone = sanitize_text_field($_POST['phone']);
			$postid = intval($_POST['postid']);
			$optionid = intval($_POST['optionid']);
			$type = sanitize_text_field($_POST['type']);


			$price = sanitize_text_field($_POST['price']);

			$userquery = get_user_by('email', $email);
			if ($userquery) {
				$uid = $userquery->ID;
			} else {
				$uid = 1;
			};

			$post_content = '';
			$my_post = array(
				'post_type' => 'purchases',
				'post_title'    => sanitize_text_field($_POST['title']),
				'post_content'  => $post_content,
				'post_status'   => "publish",
				'post_author'   => intval($uid),
				'meta_input' => array(
					'price' => $price,
					'type' => $type,
					'buyer' => $email,
					'phone' => $phone,
					'itemid' => $postid,
					'optionid' => $optionid,
					'status' => 'pending',
				)
			);

			if ((is_numeric($price) == false || $price == 0) && $type == 'events') {
				$my_post['meta_input']['status'] = 'paid';
			}

			$post_id = wp_insert_post($my_post);

			if (is_numeric($post_id)) {

				if ((is_numeric($price) == false || $price == 0) && $type == 'events') {

					$emailargs = array(
						'to' => $email,
						'subject' => 'MUSIC XXI: Приобретен Билет',
						'event' => sanitize_text_field($_POST['title'])
					);
					Emails::sendEmail('completepurchaseevent', $emailargs);
				}

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

	public static function post_type_purchases()
	{
		register_post_type(
			'purchases',
			array(
				'label' => null,
				'labels' => array(
					'name'               => 'Purchases', // основное название для типа записи
					'singular_name'      => 'Purchase', // название для одной записи этого типа
					'add_new'            => 'Add purchase', // для добавления новой записи
					'add_new_item'       => 'Adding purchase', // заголовка у вновь создаваемой записи в админ-панели.
					'edit_item'          => 'Edit purchase', // для редактирования типа записи
					'new_item'           => 'New purchase', // текст новой записи
					'view_item'          => 'View purchase', // для просмотра записи этого типа.
					'search_items'       => 'Search purchase', // для поиска по этим типам записи
					'not_found'          => 'Not found', // если в результате поиска ничего не было найдено
					'not_found_in_trash' => 'Not found in trash', // если не было найдено в корзине
					'menu_name'          => 'Purchases', // название меню
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
					'slug' => 'purchases',
					'with_front' => FALSE,
				),
				'supports' => array(
					'custom-fields',
					'title',
					'author',
					'editor',
					'excerpt'
				)
			)
		);
	}

	static function taxonomy_type_purchase_status()
	{

		$worklabels = array(
			'name'              => __('Purchase Status', 'muz21'),
			'singular_name'     => __('Status', 'muz21'),
			'search_items'      => __('Search Statuses', 'muz21'),
			'all_items'         => __('All Statuses', 'muz21'),
			'parent_item'       => __('Parent Status', 'muz21'),
			'parent_item_colon' => __('Parent Status:', 'muz21'),
			'edit_item'         => __('Edit Status', 'muz21'),
			'update_item'       => __('Update Status', 'muz21'),
			'add_new_item'      => __('Add New Status', 'muz21'),
			'new_item_name'     => __('New Status Name', 'muz21'),
		);

		register_taxonomy('purchase-status', array('purchases'), array(
			'hierarchical' => true,
			'labels'       => $worklabels,
			'show_ui'      => true,
			'query_var'    => true,
			'show_in_rest' => true,
			'rewrite' => array(
				'slug' => 'purchase-status',
				'with_front' => FALSE,
			)
		));
	}

	public static function completepurchaseevent($request)
	{
		$response = array();
		$queries = array();

		parse_str($_SERVER['QUERY_STRING'], $queries);
		$queriessorted = $queries;
		sort($queriessorted);
		//http_response_code(200);
		$secret = 'BFs2CRQxfU5ydFPnEedXYrWu';
		$amount = $queries['amount'];
		$mdOrder = $queries['mdOrder'];
		$orderNumber = filter_var($queries['orderNumber'], FILTER_SANITIZE_NUMBER_INT);
		$checksum = $queries['checksum'];
		$operation = $queries['operation'];
		$status = $queries['status'];
		$email = filter_var($queries['clientId'], FILTER_SANITIZE_EMAIL);

		$securitystring = ''; 		//'amount;'.$amount.';clientId;'.$email.';mdOrder;'.$mdOrder.';operation;'.$operation.';orderNumber;'.$orderNumber.';status;'.$status.';';
		foreach ($queriessorted as $k => $q) {
			$securitystring .= $k . ';' . $q . ';';
		}

		$hmac = hash_hmac('sha256', $securitystring, $secret);

		if ($checksum != $hmac) {
			http_response_code(403);
			die();
		} else {
			http_response_code(200);
		};

		if ($status == 0) die();

		if ($operation == 'deposited') {
			$status = 'paid';
		} else if ($operation == 'declinedByTimeout' || $operation == 'refunded' || $operation == 'reversed') {
			$status = 'cancel';
		} else {
			die();
		}

		$my_post = array(
			'ID' => $orderNumber,
			'meta_input' => array(
				'status' => $status,
			)
		);

		$result = wp_update_post($my_post);

		if ($status == 'paid') {
			$emailargs = array(
				'to' => $email,
				'subject' => 'MUSIC XXI: Приобретен Билет',
				'post_id' => $orderNumber,
				'image' => get_the_post_thumbnail_url($orderNumber,'medium'),
				'title' => get_the_title($orderNumber)
			);
			Emails::sendEmail('completepurchaseevent', $emailargs);
		}

		die();
	}
}

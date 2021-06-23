<?php

namespace Core;

class Purchases
{
	public function __construct()
	{
		add_action('init', ['Purchases', 'post_type_purchases']);
	}

	//ADD PURCHASE POST TYPE

	function post_type_purchases()
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


	function buygcoins($request)
	{
		http_response_code(200);
		$secret = '';
		$validity = strip_tags($request['notification_type']) . '&' . strip_tags($request['operation_id']) . '&' . strip_tags($request['amount']) . '&' . strip_tags($request['currency']) . '&' . strip_tags($request['datetime']) . '&' . strip_tags($request['sender']) . '&' . strip_tags($request['codepro']) . '&' . $secret . '&' . strip_tags($request['label']);
		$shalocal = sha1($validity);
		$amount = (int)$request['withdraw_amount'];
		if ($shalocal === $request['sha1_hash'] && $request['codepro'] === 'false') {

			$id = $request['label'];

			$gcoins = $amount;

			$balance = get_user_meta($id, 'gcoins', true);
			if (empty($balance)) {
				$balance = 0;
			};
			//update_user_meta($request['label'], 'debugf', '3 codepro='.$request['codepro'].' balance='.$balance.' amount='.$request['withdraw_amount'].' '.sha1($validity).' '.$request['sha1_hash']);
			update_user_meta($id, 'gcoins', $balance + $gcoins);

			$my_post = array(
				'post_type' => 'purchases',
				'post_title'    => 'Rubles by ' . $id,
				'post_content'  => "",
				'post_status'   => "publish",
				'post_author'   => $id,
				'meta_input' => array(
					'receiver' => 1,
					'game' => 0,
					'paid' => $gcoins,
					'type' => 'gcoins'
				)
			);

			$post_id = wp_insert_post($my_post);
		} else {
			//
		};
	}
}

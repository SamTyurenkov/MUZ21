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
				'post_status'   => "draft",
				'post_author'   => intval($uid),
				'meta_input' => array(
					'price' => $price,
					'type' => $type,
					'buyer' => $email,
					'phone' => $phone,
					'postid' => $postid,
					'optionid' => $optionid,
					'status' => 'pending',
				)
			);

			if (is_numeric($price) == false && $type == 'event') {
				$my_post['meta_input']['status'] = 'paid';
			}

			$post_id = wp_insert_post($my_post);

			if (is_numeric($post_id)) {

				if (is_numeric($price) == false && $type == 'event') {
					//Emails::sendEmail('ticket', array());
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

	public static function completepurchase($request)
	{

		$queries = array();
		parse_str($_SERVER['QUERY_STRING'], $queries);

		http_response_code(200);
		$secret = 'BFs2CRQxfU5ydFPnEedXYrWu';
		$validity = strip_tags($request['notification_type']) . '&' . strip_tags($request['operation_id']) . '&' . strip_tags($request['amount']) . '&' . strip_tags($request['currency']) . '&' . strip_tags($request['datetime']) . '&' . strip_tags($request['sender']) . '&' . strip_tags($request['codepro']) . '&' . $secret . '&' . strip_tags($request['label']);
		$shalocal = sha1($validity);
		$amount = (int)$request['withdraw_amount'];
		if ($shalocal === $request['sha1_hash'] && $request['codepro'] === 'false') {

			$amount = (int)$request['withdraw_amount'];

			$label = explode('&', $request['label']);
			$option = $label[0];

			$id = $label[1];
			$email = $label[2];

			$userquery = get_user_by('email', $email);
			if ($userquery) {
				$buyer = $userquery->ID;
				$postauth = $buyer;
			} else {
				$buyer = '';
				$postauth = 1;
			};


			$product = get_the_title($id);

			$from = 'no-reply@body-shop.top'; // Set whatever you want like mail@yourdomain.com
			$sender = 'From: Body Shop <' . $from . '>' . "\r\n";
			$headers[] = 'MIME-Version: 1.0' . "\r\n";
			$headers[] = 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers[] = "X-Mailer: PHP \r\n";
			$headers[] = 'Reply-To: ' . $to . "\r\n" .
				$headers[] = $sender;

			//PODAROCHNII SERTIFIKAT 
			if ($id == 711) {
				$email2 = $label[3];
				$value = $label[4];
				$textm = '<br>Подарочный Сертификат на ' . $value . ' рублей. <br>От ' . $email . ' для ' . $email2 . '. <br>С учетом скидки, оплачено: ' . $amount . ' рублей.';
				$text2 = '<br>Подарочный Сертификат на ' . $value . ' рублей. <br>От ' . $email . ' для ' . $email2;

				$my_post = array(
					'post_type' => 'purchases',
					'post_title'    => "Покупка",
					'post_content'  => "",
					'post_status'   => "publish",
					'post_author'   => $postauth,
					'meta_input' => array(
						'buyer' => $email,
						'buyerid' => $buyer,
						'phone' => '',
						'receiver' => $email2,
						'itemid' => $id,
						'item' => $product . ' ' . $value,
						'paid' => $amount,
					)
				);

				$post_id = wp_insert_post($my_post);

				$to = $email;
				$subject = 'Body Shop: Покупка на сайте';

				$message = '<!DOCTYPE html><html><head><base target="_blank"></head><body><table width="100%" border="0"><td align="center" style="background:#222;width:100%"><div id="brand" style="color:#fff;font-size:20px;line-height:80px;text-align:center">BODY SHOP</div><div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto"><table width="88%">';
				$message .= '<div id="headerimage" style="width:100%;height:300px;background:url(' . get_the_post_thumbnail_url($id, 'medium') . ') no-repeat center center;background-size:cover"></div><div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">';
				$message .= '<h2>Покупка на сайте</h2><p>Это письмо - подтверждение вашей покупки на сайте Body Shop: ' . $textm . '</p>';
				$message .= '<p>Получатель сертификата получит похожее письмо, но без указания суммы, которую вы оплатили. Также в письме будут указания как использовать сертификат и записаться к нашим специалистам.</p><p>Номер заказа: ' . $post_id . '</p>';
				$message .= '<p>Наши контакты:<br><b>Телефон/Whatsapp: </b><a href="tel:+79119210605">+79119210605</a></p>';
				$message .= '<p><b>Instagram: </b><a href="https://www.instagram.com/body_shop.top/">@body_shop.top</a></p>';
				$message .= '<p><b>Vk.com: </b><a href="https://vk.com/body_shop_top">@body_shop_top</a></p>';
				$message .= '</div></table></div><table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table></td></table></body></html>';

				$mail = wp_mail($to, $subject, $message, $headers);
				if ($mail) {
					$response['buyer'] = 1;
				} else {
					$response['buyer'] = 2;
				};

				$to = $email2;
				$subject = 'Body Shop: Вам подарок!';

				$message = '<!DOCTYPE html><html><head><base target="_blank"></head><body><table width="100%" border="0"><td align="center" style="background:#222;width:100%"><div id="brand" style="color:#fff;font-size:20px;line-height:80px;text-align:center">BODY SHOP</div><div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto"><table width="88%">';
				$message .= '<div id="headerimage" style="width:100%;height:300px;background:url(' . get_the_post_thumbnail_url($id, 'medium') . ') no-repeat center center;background-size:cover"></div><div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">';
				$message .= '<h2>Вам Подарок!</h2><p>Вам подарили: ' . $text2 . '</p>';
				$message .= '<p>Что делать дальше? Перейдите на наш сайт - <a href="https://body-shop.top">Body Shop</a>, чтобы узнать о наших услугах. А затем запишитесь на прием к специалисту удобным вам способом!</p><p>Номер сертификата: ' . $post_id . '</p>';
				$message .= '<p>Наши контакты:<br><b>Телефон/Whatsapp: </b><a href="tel:+79119210605">+79119210605</a></p>';
				$message .= '<p><b>Instagram: </b><a href="https://www.instagram.com/body_shop.top/">@body_shop.top</a></p>';
				$message .= '<p><b>Vk.com: </b><a href="https://vk.com/body_shop_top">@body_shop_top</a></p>';
				$message .= '</div></table></div><table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table></td></table></body></html>';

				$mail = wp_mail($to, $subject, $message, $headers);
				if ($mail) {
					$response['gifter'] = 1;
				} else {
					$response['gifter'] = 2;
				};
			}
			//AKTSII I USLUGI
			else {
				$phone = $label[3];

				if ($option == 1) {
					$textm = '<br>Запись к специалисту на ' . $product . '. <br>От ' . $email . ', телефон: ' . $phone . '. <br>Оплачено: ' . $amount . ' рублей.';
				} else if ($option == 2) {
					$textm = '<br>Запись к ведущему специалисту на ' . $product . '. <br>От ' . $email . ', телефон: ' . $phone . '. <br>Оплачено: ' . $amount . ' рублей.';
				}

				$my_post = array(
					'post_type' => 'purchases',
					'post_title'    => "Покупка",
					'post_content'  => "",
					'post_status'   => "publish",
					'post_author'   => $postauth,
					'meta_input' => array(
						'buyer' => $email,
						'buyerid' => $buyer,
						'phone' => $phone,
						'receiver' => $email,
						'itemid' => $id,
						'item' => $product . ' ' . $value,
						'paid' => $amount,
					)
				);

				$post_id = wp_insert_post($my_post);

				$to = $email;
				$subject = 'Body Shop: Покупка на сайте';

				$message = '<!DOCTYPE html><html><head><base target="_blank"></head><body><table width="100%" border="0"><td align="center" style="background:#222;width:100%"><div id="brand" style="color:#fff;font-size:20px;line-height:80px;text-align:center">BODY SHOP</div><div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto"><table width="88%">';
				$message .= '<div id="headerimage" style="width:100%;height:300px;background:url(' . get_the_post_thumbnail_url($id, 'medium') . ') no-repeat center center;background-size:cover"></div><div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">';
				$message .= '<h2>Покупка на сайте</h2><p>Это письмо - подтверждение вашей покупки на сайте Body Shop: ' . $textm . '</p>';
				$message .= '<p>Если мы вам еще не позвонили сами, свяжитесь с нами удобным вам способом, чтобы записаться на прием к специалисту.</p><p>Номер заказа: ' . $post_id . '</p>';
				$message .= '<p>Наши контакты:<br><b>Телефон/Whatsapp: </b><a href="tel:+79119210605">+79119210605</a></p>';
				$message .= '<p><b>Instagram: </b><a href="https://www.instagram.com/body_shop.top/">@body_shop.top</a></p>';
				$message .= '<p><b>Vk.com: </b><a href="https://vk.com/body_shop_top">@body_shop_top</a></p>';
				$message .= '</div></table></div><table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table></td></table></body></html>';

				$mail = wp_mail($to, $subject, $message, $headers);
				if ($mail) {
					$response['buyer'] = 1;
				} else {
					$response['buyer'] = 2;
				};
				$response['gifter'] = 2;
			}

			$to = 'info@body-shop.top';
			$subject = 'Body Shop: Покупка на сайте';

			$message = '<!DOCTYPE html><html><head><base target="_blank"></head><body><table width="100%" border="0"><td align="center" style="background:#222;width:100%"><div id="brand" style="color:#fff;font-size:20px;line-height:80px;text-align:center">BODY SHOP</div><div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto"><table width="88%">';
			$message .= '<div id="headerimage" style="width:100%;height:300px;background:url(' . get_the_post_thumbnail_url($id, 'medium') . ') no-repeat center center;background-size:cover"></div><div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">';
			$message .= '<h2>Покупка на сайте</h2><p>На сайте Body Shop совершена покупка: ' . $textm . '</p>';
			$message .= '<p>Не забудьте согласовать время посещения, а также уточнить получение ими письма с подтверждением покупки/сертификата!</p><p>Номер заказа: ' . $post_id . '</p>';
			$message .= '</div></table></div><table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table></td></table></body></html>';

			$mail = wp_mail($to, $subject, $message, $headers);
			if ($mail) {
				$response['admin'] = 1;
			} else {
				$response['admin'] = 2;
			};
			update_user_meta(1, 'debugf', $response['admin'] . $response['buyer'] . $response['gifter'] . 'codepro=' . $request['codepro'] . ' balance=' . $balance . ' amount=' . $request['withdraw_amount'] . ' ' . sha1($validity) . ' ' . $request['sha1_hash']);
			echo json_encode($response);
			die();
		} else {
			update_user_meta(1, 'debugf', 'codepro=' . $request['codepro'] . ' balance=' . $balance . ' amount=' . $request['withdraw_amount'] . ' ' . sha1($validity) . ' ' . $request['sha1_hash']);
			echo json_encode($response);
			die();
		};
	}
}

<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<?php

function exit_ajax(string $string = null)
{
	header('Content-Type: application/json');
	$response = array();

	$response['response'] = 'error';
	$response['details'] = $string;
	echo json_encode($response);
	die();
}

function add_blog_ajax()
{
	header('Content-Type: application/json');
	$response = array();

	if (!wp_verify_nonce($_POST["nonce"], "_add_properties")) exit_ajax();
	if (!is_numeric($_POST['id'])) exit_ajax('Необходимо заполнить базовую информацию, чтобы продолжить!');
	$userid = $_POST['id'];


	$my_post = array(
		'post_author'  => $userid,
		'post_title'   => 'Новость или Статья',
		'post_status' => 'pending',
		'post_type' => 'post',
		'post_content'   => '<p>Текст новости или статьи, нажмите на него в режиме редактирования, чтобы изменить.</p>',
		'post_name' => ''
	);
	$result = wp_insert_post($my_post);
	if (is_numeric($result)) {
		$response['response'] = 'success';
		$response['id'] = $result;
		echo json_encode($response);
		die();
	} else {
		$response['response'] = 'error';
		$response['details'] = $result;
		echo json_encode($response);
		die();
	}
}
add_action('wp_ajax_add_blog_ajax', 'add_blog_ajax');

function add_props_ajax()
{
	header('Content-Type: application/json');
	$response = array();

	if (!wp_verify_nonce($_POST["nonce"], "_add_properties")) exit_ajax();
	if (!is_numeric($_POST['id']) || !is_numeric($_POST['meta'][3]) || !is_numeric($_POST['meta'][4])) exit_ajax('Необходимо заполнить базовую информацию, чтобы продолжить!');
	$userid = $_POST['id'];
	$dtype = strip_tags($_POST['meta'][0]);
	$ptype = strip_tags($_POST['meta'][1]);
	$city = strip_tags($_POST['meta'][2]);
	$price = strip_tags($_POST['meta'][3]);
	$area = strip_tags($_POST['meta'][4]);

	$dtypes = array("kupit", "posutochno-snyat", "snyat");
	if (!in_array($dtype, $dtypes)) {
		exit_ajax('Необходимо заполнить базовую информацию, чтобы продолжить!');
	}

	$ptypes = array("kvartira", "dom", "nezhiloe", "komnata", "uchastok", "hotel", "koikomesto");
	if (!in_array($ptype, $ptypes)) {
		exit_ajax('Необходимо заполнить базовую информацию, чтобы продолжить!');
	}

	$cities = CityManager::getCities(); 
	if (!in_array($city, $cities)) {
		exit_ajax('Необходимо заполнить базовую информацию, чтобы продолжить!');
	}

	$metas = array(
		'locality-name' => $city,
		'value_price' => $price,
		'value_area' => $area
	);

	$my_post = array(
		'post_author'  => $userid,
		'post_title'   => 'Объект недвижимости',
		'post_status' => 'pending',
		'post_type' => 'property',
		'post_content'   => '<p>Описание объекта недвижимости, нажмите на него в режиме редактирования, чтобы изменить.</p>',
		'post_name' => '',
		'meta_input' => $metas,
	);
	$result = wp_insert_post($my_post);
	if (is_numeric($result)) {
		wp_set_object_terms($result, array($dtype, $ptype), 'property-type', true);
		$response['response'] = 'success';
		$response['id'] = $result;
		echo json_encode($response);
		die();
	} else {
		$response['response'] = 'error';
		$response['error'] = $result;
		echo json_encode($response);
		die();
	}
}
add_action('wp_ajax_add_props_ajax', 'add_props_ajax');

function update_blog_ajax()
{
	if (!wp_verify_nonce($_POST["nonce"], "_edit_blog")) exit_ajax('Что-то не так с секретом');
	if (!is_numeric($_POST['id'])) exit_ajax('Мы не нашли эту запись');
	if (!current_user_can('edit_post', $_POST['id'])) exit_ajax('Вы не можете редактировать эту запись');
	$id = $_POST['id'];
	$val = strip_tags($_POST['metavalue']);
	$meta = strip_tags($_POST['metaname']);



	header('Content-Type: application/json');
	$response = array();

	switch ($meta) {
		case 'category':
			$ptypes = array("blog", "news");
			if (!in_array($val, $ptypes)) {
				exit_ajax($meta . ' ' . $val);
			} else {
		
				$result = wp_set_object_terms($id, array($val), 'category', false);
				$response['response'] = 'success';
				$response['details'] = $result;
				echo json_encode($response);
				die();
			}
			break;

		case 'locality-name':
			$cities = CityManager::getCities(); 
	
			if (!in_array($val, $cities)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'tags':
			$val = sanitize_text_field($val);
			$val = strtolower(filter_var($val, FILTER_SANITIZE_SPECIAL_CHARS));
			if (strlen($val) < 101) {
				wp_set_post_tags($id, $val, false);
				$my_post = array(
					'ID' => $id,
				);
				wp_update_post($my_post);
				$response['response'] = "success";
				echo json_encode($response);
				die();
			} else {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'title':
			$val = sanitize_text_field($val);
			$my_post = array(
				'ID'           => $id,
				'post_title'   => $val,
				'post_name' => '',
			);
			wp_update_post($my_post);
			$response['response'] = 'success';
			echo json_encode($response);
			die();
			break;

		default:
			exit_ajax('unknown error');
			break;
	}

	update_post_meta($id, $meta, $val);
	$response['response'] = 'success';
	$response['meta'] = $meta;
	$response['val'] = $val;
	echo json_encode($response);
	die();
}
add_action('wp_ajax_update_blog_ajax', 'update_blog_ajax');

function update_newsletter_ajax()
{
	if (!wp_verify_nonce($_POST["nonce"], "_edit_newsletter")) exit_ajax('Что-то не так с секретом');
	if (!is_numeric($_POST['id'])) exit_ajax('Мы не нашли эту запись');
	if (!current_user_can('edit_post', $_POST['id'])) exit_ajax('Вы не можете редактировать эту запись');
	$id = $_POST['id'];
	$val = strip_tags($_POST['metavalue']);
	$meta = strip_tags($_POST['metaname']);

	header('Content-Type: application/json');
	$response = array();

	switch ($meta) {

		case 'title':
			$val = sanitize_text_field($val);
			$my_post = array(
				'ID'           => $id,
				'post_title'   => $val,
				'post_name' => '',
			);
			wp_update_post($my_post);
			$response['response'] = 'success';
			echo json_encode($response);
			die();
			break;

		case 'newsletter_btn_text':
		case 'newsletter_btn_url':
		case 'newsletter_midline':
			$val = sanitize_text_field($val);
			break;

		case 'new_emails':
			$val = str_replace(' ', '', $val);
			$providedarray = explode(',', $val);
			$formattedarray = array();
			foreach ($providedarray as $v) {
				if (is_email($v)) array_push($formattedarray, $v);
			}
			$string = implode(',', $formattedarray);
			update_field($meta, $string, $id);
			$response['response'] = 'success';
			$response['meta'] = $meta;
			$response['val'] = $val;
			echo json_encode($response);
			die();
			break;

		default:
			exit_ajax();
			break;
	}

	update_post_meta($id, $meta, $val);
	$response['response'] = 'success';
	$response['meta'] = $meta;
	$response['val'] = $val;
	echo json_encode($response);
	die();
}
add_action('wp_ajax_update_newsletter_ajax', 'update_newsletter_ajax');

function update_props_ajax()
{

	if (!wp_verify_nonce($_POST["nonce"], "_edit_properties")) exit_ajax('Что-то не так с секретом');
	if (!is_numeric($_POST['id'])) exit_ajax('Мы не нашли это объявление');
	if (strlen($_POST['metavalue']) > 300) exit_ajax('Максимум 300 символов');
	$id = $_POST['id'];
	$val = filter_var($_POST['metavalue'], FILTER_SANITIZE_STRING);
	$meta = filter_var($_POST['metaname'], FILTER_SANITIZE_STRING);
	$obj_id = filter_var($_POST['obj_id'], FILTER_SANITIZE_NUMBER_INT);


	header('Content-Type: application/json');
	$response = array();

	wp_cache_delete('feed_avito_' . $obj_id);
	wp_cache_delete('feed_cian_' . $obj_id);
	wp_cache_delete('feed_yandex_' . $obj_id);

	switch ($meta) {
		case 'propertytype':
			$ptypes = array("kvartira", "dom", "nezhiloe", "komnata", "uchastok", "hotel", "koikomesto");
			if (!in_array($val, $ptypes)) {
				exit_ajax();
			} else {
				$terms = get_the_terms($id, 'property-type');
				$newterms = array($val);

				foreach ($terms as $term) {
					if (!in_array($term->slug, $ptypes)) {
						$newterms[] = $term->slug;
					}
				}
				wp_set_object_terms($id, $newterms, 'property-type', false);
				$response['response'] = 'success';
				$response['details'] = $newterms;
				$response['meta'] = $meta;
				$response['val'] = $val;
				echo json_encode($response);
				die();
			}
			break;

		case 'dealtype':
			$dtypes = array("kupit", "posutochno-snyat", "snyat");
			if (!in_array($val, $dtypes)) {
				exit_ajax();
			} else {
				$terms = get_the_terms($id, 'property-type');
				$newterms = array($val);

				foreach ($terms as $term) {
					if (!in_array($term->slug, $dtypes)) {
						$newterms[] = $term->slug;
					}
				}
				wp_set_object_terms($id, $newterms, 'property-type', false);
				$response['response'] = 'success';
				$response['details'] = $newterms;
				$response['meta'] = $meta;
				$response['val'] = $val;
				echo json_encode($response);
				die();
			}
			break;

		case 'locality-name':
			$cities = CityManager::getCities(); 
			if (!in_array($val, $cities)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'housetype':
			$housetypes = array("Кирпичный", "Панельный", "Блочный", "Монолитный", "Деревянный");
			if (!in_array($val, $housetypes)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'market_type':
			$markettypes = array("Вторичка", "Новостройка");
			if (!in_array($val, $markettypes)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'wallstype':
			$wallstypes = array("Кирпич", "Брус", "Бревно", "Газоблоки", "Металл", "Пеноблоки", "Сэндвич-панели", "Ж/б панели", "Экспериментальные материалы");
			if (!in_array($val, $wallstypes)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'propertyrights':
			$propertyrights = array("Собственник", "Посредник");
			if (!in_array($val, $propertyrights)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'houseobjecttype':
			$houseobjecttype = array("Дом", "Дача", "Коттедж", "Таунхаус");
			if (!in_array($val, $houseobjecttype)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'landobjecttype':
			$landobjecttype = array("Поселений (ИЖС)", "Сельхозназначения (СНТ, ДНП)", "Промназначения");
			if (!in_array($val, $landobjecttype)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'sublocality-name':
		case 'address_2':
		case 'address1':
			$val = sanitize_text_field($val);
			break;

		case 'online-show':
			$onlineshow = array("Могу показать", "Не хочу");
			if (!in_array($val, $onlineshow)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'kommun-platezh':
			$kommunal = array("включены", "не включены");
			if (!in_array($val, $kommunal)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'commercial-type':
			$dealstatus = array("auto repair", "business", "free purpose", "hotel", "land", "legal address", "manufacturing", "office", "public catering", "retail", "warehouse");
			if (!in_array($val, $dealstatus)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'internet':
			$internet = array("Интернет за доп.плату", "Интернет бесплатно", "Интернета нет");
			if (!in_array($val, $internet)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'television':
			$tv = array("Кабельное ТВ", "Обычное ТВ", "Телевизора нет");
			if (!in_array($val, $tv)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'deal-status':
			$dealstatus = array("Первичная продажа", "Переуступка");
			if (!in_array($val, $dealstatus)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'building-state':
			$buildstate = array("Построен, но не сдан", "Сдан", "Строится");
			if (!in_array($val, $buildstate)) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'youtube-video':
			if (strpos($val, 'youtu.be') !== false && strpos($val, '?') !== true && strlen($val) < 350) {
				$namearray = explode('/', $val);
				$val = end($namearray);
			} else if (strpos($val, 'youtube.com') !== false && strpos($val, '?') !== false && strlen($val) < 350) {
				$namearray = explode('=', $val);
				$val = $namearray[1];
				$namearray = explode('&', $val);
				$val = $namearray[0];
			} else if ($val == '') {
				$val = '';
			} else {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'building-name';
			$val = sanitize_text_field($val);
			break;

		case 'metro_spb';
		case 'metro_msk';
			if (!is_numeric($val)) {
				exit_ajax($meta . ' ' . $val);
			}
			update_field($meta, $val, $id);
			$response['response'] = 'success';
			$response['meta'] = $meta;
			$response['val'] = $val;
			echo json_encode($response);
			die();
			break;

		case 'value_price';
		case 'value_area';
		case 'lot_area';
		case 'rooms';
		case 'floor';
		case 'floors_total';
		case 'min_stay';
		case 'zalog';
		case 'agent-fee';
		case 'krovatis';
		case 'yandex';
		case 'avito';
		case 'cian';
		case 'yandexnewdev';
		case 'avitonewdev';
		case 'ciannewdev';
		case 'avitokorpus';
		case 'ciankorpus';
		case 'yandexkorpus';
		case 'built-year';
		case 'ready-quarter';
		case 'avitoid';
			if (!is_numeric($val) && ($val != '')) {
				exit_ajax($meta . ' ' . $val);
			}
			break;

		case 'title':
			$val = sanitize_text_field($val);
			$my_post = array(
				'ID'           => $id,
				'post_title'   => $val,
				'post_name' => '',
			);
			wp_update_post($my_post);
			$response['meta'] = $meta;
			$response['val'] = $val;
			$response['response'] = 'success';
			echo json_encode($response);
			die();
			break;

		default:
			exit_ajax();
			break;
	}

	update_post_meta($id, $meta, sanitize_text_field($val));
	$response['response'] = 'success';
	$response['meta'] = $meta;
	$response['val'] = $val;
	echo json_encode($response);
	die();
}
add_action('wp_ajax_update_props_ajax', 'update_props_ajax');

function cat_blog_ajax()
{
	if (!is_numeric($_GET['page'])) return;
	if (!is_numeric($_GET['obj_id'])) return;

	header('Content-Type: application/json');
	$response = array();

	$args = array(
		'post_type' => 'post',
		'order'     => 'DESC',
		'post_status' => 'publish',
		'orderby'       => 'modified',
		'posts_per_page' => 9,
		'paged'    => $_GET['page'],
		'tax_query' => array(
			array(
				'taxonomy'  => 'category',
				'field'     => 'term_id',
				'terms' => array($_GET['obj_id']),
			)
		)
	);
	if ($_GET['obj_id'] == 1) $args['orderby'] = 'date';

	$loop = new WP_Query($args);

	$amount = 0;
	$response['response'] = '';

	if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();
			//$array = get_post_meta(get_the_ID(),'',true);

			$thumbnail = get_the_post_thumbnail_url(null, 'thumbnail');

			$out = '<a href="' . get_the_permalink() . '" class="catblock2">';
			$out .= '<img src="' . $thumbnail . '">';
			$out .= '<h4>' . get_the_title() . '</h4>';
			$out .= '</a>';

			$response['response'] .= $out;
			$amount++;

		endwhile;
	endif;

	$response['amount'] = $amount;

	wp_reset_postdata();
	echo json_encode($response);
	die();
}

add_action('wp_ajax_nopriv_cat_blog_ajax', 'cat_blog_ajax');
add_action('wp_ajax_cat_blog_ajax', 'cat_blog_ajax');

function tag_blog_ajax()
{
	if (!is_numeric($_GET['page'])) return;
	if (!is_numeric($_GET['obj_id'])) return;

	header('Content-Type: application/json');
	$response = array();


	$args = array(
		'post_type' => 'post',
		'order'     => 'DESC',
		'post_status' => 'publish',
		'orderby'       => 'modified',
		'posts_per_page' => 9,
		'paged'    => $_GET['page'],
		'tax_query' => array(
			array(
				'taxonomy'  => 'post_tag',
				'field'     => 'term_id',
				'terms' => array($_GET['obj_id']),
			)
		)
	);

	$loop = new WP_Query($args);

	$amount = 0;
	$response['response'] = '';

	if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();
			//$array = get_post_meta(get_the_ID(),'',true);

			$thumbnail = get_the_post_thumbnail_url(null, 'thumbnail');

			$out = '<a href="' . get_the_permalink() . '" class="catblock2">';
			$out .= '<img src="' . $thumbnail . '">';
			$out .= '<h4>' . get_the_title() . '</h4>';
			$out .= '</a>';

			$response['response'] .= $out;
			$amount++;

		endwhile;
	endif;

	$response['amount'] = $amount;

	wp_reset_postdata();
	echo json_encode($response);
	die();
}

add_action('wp_ajax_nopriv_tag_blog_ajax', 'tag_blog_ajax');
add_action('wp_ajax_tag_blog_ajax', 'tag_blog_ajax');

function cat_post_ajax()
{
	if (!is_numeric($_GET['page'])) return;
	if (!is_numeric($_GET['obj_id'])) return;

	$city = strip_tags($_GET['options'][0]);
	$ptype = strip_tags($_GET['options'][1]);
	$sort = strip_tags($_GET['options'][2]);

	header('Content-Type: application/json');
	$response = array();

	$args = array(
		'post_type' => 'property',
		'order'     => 'DESC',
		'post_status' => 'publish',
		'orderby'       => 'modified',
		'posts_per_page' => 9,
		'paged'    => $_GET['page'],
		'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy'  => 'property-type',
				'field'     => 'term_id',
				'terms'     => array(18),
				'operator'  => 'NOT IN'
			),
			array(
				'taxonomy'  => 'property-type',
				'field'     => 'term_id',
				'terms' => array($_GET['obj_id']),
			)
		)
	);

	if (!empty($ptype) && $ptype != 'empty') {
		$args['tax_query'][2] = array(
			'taxonomy'  => 'property-type',
			'field'     => 'slug',
			'terms' => array($ptype),
		);
	}

	if (!empty($city) && $city != 'empty') {
		$args['meta_key'] = 'locality-name';
		$args['meta_query'][0] = array(
			'meta_query' => array(
				array(
					'key' => 'locality-name',
					'value' => $city
				)
			)
		);
	}

	if ($sort == 'price') {
		$args['order'] = 'ASC';
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = 'value_price';
	}

	$loop = new WP_Query($args);

	$amount = 0;
	$response['response'] = '';

	if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();
			$array = get_post_meta(get_the_ID(), '', true);

			$thumbnail = get_the_post_thumbnail_url(null, 'thumbnail');


			$out = '<a href="' . get_the_permalink() . '" class="catblock2">';
			$out .= '<img src="' . $thumbnail . '">';
			$out .= '<h4>' . get_the_title() . '</h4>';
			if (array_key_exists('value_price', $array)) {
				$out .= '<div class="catprop"><i class="icon-rouble"></i> ' . number_format(get_post_meta(get_the_ID(), 'value_price', true));
				if (has_term(16, 'property-type')) $out .= '/сутки';
				if (has_term(19, 'property-type')) $out .= '/месяц';
				$out .= '</div>';
			}
			if (array_key_exists('value_area', $array)) $out .= '<div class="catprop"><i class="icon-resize-full-alt"></i> ' . $array['value_area'][0] . ' кв.м.</div>';

			if (array_key_exists('locality-name', $array)) {
				$out .= '<div class="catprop"><i class="icon-location"></i> ' . $array['locality-name'][0] . ', ';
				if (get_post_meta(get_the_ID(), 'sublocality-name', true)) $out .= $array['sublocality-name'][0] . ', ';
				if (array_key_exists('address_2', $array) && ($array['address_2'] != '')) $out .= $array['address_2'][0] . ', ';
				if (array_key_exists('address1', $array) && ($array['address1'] != '')) $out .= $array['address1'][0] . ', ';
				$out .= '</div>';
			}
			$out .= '</div></a>';

			$response['response'] .= $out;
			$amount++;

		endwhile;
	endif;

	$response['amount'] = $amount;

	wp_reset_postdata();
	echo json_encode($response);
	die();
}

add_action('wp_ajax_nopriv_cat_post_ajax', 'cat_post_ajax');
add_action('wp_ajax_cat_post_ajax', 'cat_post_ajax');


function auth_post_ajax()
{
	if (!is_numeric($_GET['page'])) return;
	if (!is_numeric($_GET['obj_id']) && (current_user_can('editor' || 'administrator') == false)) return; //FOR ADMINKA
	if (!is_numeric($_GET['posttype'])) return;

	$city = strip_tags($_GET['options'][0]);
	$ptype = strip_tags($_GET['options'][1]);
	$sort = strip_tags($_GET['options'][2]);
	$dtype = strip_tags($_GET['options'][3]);
	if (isset($_GET['options'][4])) {
		$status = strip_tags($_GET['options'][4]);
	} else if (isset($_GET['options'][4]) && strip_tags($_GET['options'][4]) == 'all') {
		$status = array('publish', 'pending', 'draft');
	} else {
		$status = 'empty';
	}
	$author = strip_tags($_GET['obj_id']);

	header('Content-Type: application/json');
	$response = array();

	if ($_GET['posttype'] == 1) {
		$args = array(
			'post_type' => 'property',
			'order'     => 'DESC',
			'post_status' => 'publish',
			'orderby'       =>  'modified',
			'posts_per_page' => 9,
			'paged'    => $_GET['page'],
			'tax_query' => array(
				'relation' => 'AND'
			)
		);
		if ($author != '0') {
			$args['author'] = $author;
		}
		if (!empty($ptype) && $ptype != 'empty') {
			$args['tax_query'][] = array(
				'taxonomy'  => 'property-type',
				'field'     => 'slug',
				'terms' => array($ptype),
			);
		}
		if (!empty($dtype) && $dtype != 'empty') {
			$args['tax_query'][] = array(
				'taxonomy'  => 'property-type',
				'field'     => 'slug',
				'terms' => array($dtype),
			);
		}

		if (!empty($city) && $city != 'empty') {
			$args['meta_key'] = 'locality-name';
			$args['meta_query'][] = array(
				'meta_query' => array(
					array(
						'key' => 'locality-name',
						'value' => $city
					)
				)
			);
		}

		if ($sort == 'price') {
			$args['order'] = 'ASC';
			$args['orderby'] = 'meta_value_num';
			$args['meta_key'] = 'value_price';
		}
		if ($status != 'empty') {
			$args['post_status'] = $status;
		}
		$loop = new WP_Query($args);
		$amount = 0;
		$response['response'] = '';

		if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();
		if (get_post_status() == 'auto-draft') continue;
				$array = get_post_meta(get_the_ID(), '', true);

				$thumbnail = get_the_post_thumbnail_url(null, 'thumbnail');

				$out = '<a href="' . get_the_permalink() . '" class="catblock2">';
				$out .= '<img src="' . $thumbnail . '">';
				$out .= '<h4>' . get_the_title() . '</h4>';
				if (array_key_exists('value_price', $array)) {
					$out .= '<div class="catprop"><i class="icon-rouble"></i> ' . number_format(floatval(get_post_meta(get_the_ID(), 'value_price', true)));
					if (has_term(16, 'property-type')) $out .= '/сутки';
					if (has_term(19, 'property-type')) $out .= '/месяц';
					$out .= '</div>';
				}
				if (array_key_exists('value_area', $array)) $out .= '<div class="catprop"><i class="icon-resize-full-alt"></i> ' . $array['value_area'][0] . ' кв.м.</div>';

				if (array_key_exists('locality-name', $array)) {
					$out .= '<div class="catprop"><i class="icon-location"></i> ' . $array['locality-name'][0];
					if (array_key_exists('sublocality-name', $array)) $out .= ', ' . $array['sublocality-name'][0];
					$out .= '</div>';
				}
				if ($author == '0') {
					$out .= '<div class="catprop">' . get_the_author_meta("display_name") . '</div>';
				};
				if (get_post_status() == 'draft') $out .= '<hr><b>Снято с публикации</b>';
				if (get_post_status() == 'pending') $out .= '<hr><b>Черновик</b>';
				$out .= '</a>';

				$response['response'] .= $out;
				$amount++;

			endwhile;
		endif;

		$response['amount'] = $amount;
	} else if ($_GET['posttype'] == 2) {

		$args = array(
			'post_type' => 'post',
			'order'     => 'DESC',
			'post_status' => 'publish',
			'orderby'       =>  'modified',
			'posts_per_page' => 9,
			'paged'    => $_GET['page'],
		);

		if ($author != '0') {
			$args['author'] = $author;
		}

		if (!empty($city) && $city != 'empty') {
			$args['meta_key'] = 'locality-name';
			$args['meta_query'][] = array(
				'meta_query' => array(
					array(
						'key' => 'locality-name',
						'value' => $city
					)
				)
			);
		}
		if ($status != 'empty') {
			$args['post_status'] = $status;
		}

		$loop = new WP_Query($args);
		$amount = 0;
		$response['response'] = '';

		if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();
				$array = get_post_meta(get_the_ID(), '', true);

				$thumbnail = get_the_post_thumbnail_url(null, 'thumbnail');

				$out = '<a href="' . get_the_permalink() . '" class="catblock2">';
				$out .= '<img src="' . get_the_post_thumbnail_url(null, 'thumbnail') . '">';
				$out .= '<h4>' . get_the_title() . '</h4>';
				if ($author == '0') {
					$out .= '<div class="catprop">' . get_the_author_meta("display_name") . '</div>';
				};
				if (get_post_status() == 'draft') $out .= '<hr><b>Снято с публикации</b>';
				if (get_post_status() == 'pending') $out .= '<hr><b>Черновик</b>';
				$out .= '</a>';

				$response['response'] .= $out;
				$amount++;

			endwhile;
		endif;

		$response['amount'] = $amount;
	} else if ($_GET['posttype'] == 3) {

		$args = array(
			'post_type' => 'newsletter',
			'order'     => 'DESC',
			'post_status' => 'pending',
			'orderby'       =>  'modified',
			'posts_per_page' => 9,
			'paged'    => $_GET['page'],
		);

		if ($author != '0') {
			$args['author'] = $author;
		}

		$loop = new WP_Query($args);
		$amount = 0;
		$response['response'] = '';

		if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();
				$array = get_post_meta(get_the_ID(), '', true);

				$thumbnail = get_the_post_thumbnail_url(null, 'thumbnail');

				$out = '<a href="' . get_the_permalink() . '" class="catblock2">';
				$out .= '<img src="' . get_the_post_thumbnail_url(null, 'thumbnail') . '">';
				$out .= '<h4>' . get_the_title() . '</h4>';
				if ($author == '0') {
					$out .= '<div class="catprop">' . get_the_author_meta("display_name") . '</div>';
				};
				$out .= '</a>';

				$response['response'] .= $out;
				$amount++;

			endwhile;
		endif;

		$response['amount'] = $amount;
	}
	wp_reset_postdata();
	echo json_encode($response);
	die();
}

add_action('wp_ajax_nopriv_auth_post_ajax', 'auth_post_ajax');
add_action('wp_ajax_auth_post_ajax', 'auth_post_ajax');


function more_post_ajax()
{

	if (!is_numeric($_GET['page'])) return;

	header('Content-Type: application/json');
	$response = array();

	$args = array(
		'post_type' => 'property',
		'order'     => 'DESC',
		'post_status' => 'publish',
		'orderby'       => 'modified',
		'posts_per_page' => 9,
		'paged'    => $_GET['page'],
	);

	$loop = new WP_Query($args);

	$response['response'] = '';

	if ($loop->have_posts()) :  while ($loop->have_posts()) : $loop->the_post();
			$array = get_post_meta(get_the_ID(), '', true);

			$thumbnail = get_the_post_thumbnail_url(null, 'thumbnail');

			$out = '<a href="' . get_the_permalink() . '" class="catblock2">';
			$out .= '<img src="' . $thumbnail . '">';
			$out .= '<h4>' . get_the_title() . '</h4>';
			if (array_key_exists('value_price', $array)) {
				$out .= '<div class="catprop"><i class="icon-rouble"></i> ' . number_format(get_post_meta(get_the_ID(), 'value_price', true));
				if (has_term(16, 'property-type')) $out .= '/сутки';
				if (has_term(19, 'property-type')) $out .= '/месяц';
				$out .= '</div>';
			}
			if (array_key_exists('value_area', $array)) $out .= '<div class="catprop"><i class="icon-resize-full-alt"></i> ' . $array['value_area'][0] . ' кв.м.</div>';

			if (array_key_exists('locality-name', $array)) {
				$out .= '<div class="catprop"><i class="icon-location"></i> ' . $array['locality-name'][0] . ', ';
				if (get_post_meta(get_the_ID(), 'sublocality-name', true)) $out .= $array['sublocality-name'][0] . ', ';
				if (array_key_exists('address_2', $array) && ($array['address_2'] != '')) $out .= $array['address_2'][0] . ', ';
				if (array_key_exists('address1', $array) && ($array['address1'] != '')) $out .= $array['address1'][0];
				$out .= '</div>';
			}
			$out .= '</a>';

			$response['response'] .= $out;


		endwhile;
	endif;

	//$response['response'] .= $loop->request;

	wp_reset_postdata();
	echo json_encode($response);
	die();
}

add_action('wp_ajax_nopriv_more_post_ajax', 'more_post_ajax');
add_action('wp_ajax_more_post_ajax', 'more_post_ajax');


function sendNewsletter()
{
	if (!wp_verify_nonce($_GET["nonce"], "_edit_newsletter")) return;
	if (!is_numeric($_GET['id'])) return;

	$emailstring = get_post_meta($_GET['id'], 'new_emails', true);
	$btn_txt = get_post_meta($_GET['id'], 'newsletter_btn_text', true);
	$btn_url = get_post_meta($_GET['id'], 'newsletter_btn_url', true);
	$midline = get_post_meta($_GET['id'], 'newsletter_midline', true);
	$emailarray = explode(',', $emailstring);
	$successemails = array();
	$image = get_the_post_thumbnail_url($_GET['id'], 'medium');
	$title = get_the_title($_GET['id']);
	$author_id = get_post_field('post_author', $_GET['id']);
	$avatar = get_avatar_url($author_id, array('size' => 150,));
	$name = get_the_author_meta('display_name', $author_id);
	$phone = get_the_author_meta('user_phone', $author_id);
	$email = get_the_author_meta('user_email', $author_id);

	$from = 'admin@asp.sale'; // Set whatever you want like mail@yourdomain.com
	$subject = $title;
	$sender = 'From: Семён Тюреньков <' . $from . '>' . "\r\n";

	$message = '<!DOCTYPE html><html><head><base target="_blank"></head><body><table width="100%" border="0"><td align="center" style="background:#f2f2f2;width:100%"><a href="https://asp.sale" id="brand" style="text-decoration: none;font-size:20px;line-height:80px;text-align:center;color: #d03030;font-weight: 800">ASP</a><div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto"><table width="88%">';
	$message .= '<div id="headerimage" style="width:100%;height:300px;background:url(\'' . esc_attr($image) . '\')no-repeat center center;background-size:cover"></div><div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">';
	$message .= '<h2>' . esc_html($title) . '</h2>';
	$message .= '<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" style="max-width:560px"><td>' . preg_replace("/(<li>[^<>]+<\/li>)+/", "<ul>$0</ul>", wp_kses_post(get_the_content(null, null, $_GET['id']))) . '<td></table>';
	$message .=	'<table height="50" align="center" border="0" cellspacing="0" cellpadding="0" width="100%" style="max-width:360px"><td align="center" valign="bottom" height="50" style="padding:0"><a href="' . esc_attr($btn_url) . '" style="display: inline-block; max-width: 360px; width: 100%; font-size: 16px; text-align: center;  text-decoration: none;  border: 1px solid #e0e0e0;color: #d03030;  padding: 3px 7px;  line-height: 30px; font-weight: 600;  box-shadow: -1px 1px 1px rgba(0,0,0,.25);border-radius: 5px;  background: #fff;  margin-left: 1px; cursor: pointer">' . esc_html($btn_txt) . '</a></td></table>';
	$message .=	'<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" style="margin: 20px 0 0;max-width:560px"><td style="border-radius: 10px;width:80px;height:80px;background:url(\'' . esc_attr($avatar) . '\')no-repeat center center;background-size:cover"></td><td style="padding: 0 20px">' . esc_html($name) . '<br><b>' . esc_html($midline) . '</b><br>Тел: ' . esc_html($phone) . '</td></table>';
	$message .=	'</div></table></div><table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table></td></table></body></html>';

	$headers[] = 'MIME-Version: 1.0' . "\r\n";
	$headers[] = 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$headers[] = "X-Mailer: PHP \r\n";
	$headers[] = $sender;

	foreach ($emailarray as $email) {
		$to = $email;

		$mail = wp_mail($to, $subject, $message, $headers);
		if ($mail)
			array_push($successemails, $email);
	}
	$sentemails = get_post_meta($_GET['id'], 'sent_emails', true);
	$sentarray = explode(',', $sentemails);
	$finalarray = array_unique(array_merge($sentarray, $successemails));
	$finalarray = implode(',', $finalarray);
	update_post_meta($_GET['id'], 'sent_emails', $finalarray);
}
add_action('wp_ajax_nopriv_sendNewsletter', 'sendNewsletter');
add_action('wp_ajax_sendNewsletter', 'sendNewsletter');

<?php

namespace Core;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<?php

class Authors
{
	//EVERYTHING RELATED TO AUTHORS AND THEIR META

	public function __construct()
	{
		add_image_size('avatar', 300, 300, true);
		add_image_size('mini', 60, 60, true);

		//EMAIL VALIDATION CLUSTER
		add_action('rest_api_init', function () {
			register_rest_route('usermeta', '/validate/', array(
				'methods' => 'GET',
				'callback' => 'valimail',
				'permission_callback' => '__return_true'
			));
		});

		add_action('wp_ajax_valisend', ['Core\Authors', 'valisend']);
		add_action('wp_ajax_updateauth', ['Core\Authors', 'updateauth']);
		add_action('wp_ajax_updateavatar', ['Core\Authors', 'updateavatar']);
		add_filter('get_avatar', ['Core\Authors', 'avatar'], 999, 3);
		add_filter('get_avatar_url', ['Core\Authors', 'avatar_url'], 999, 3);
		add_filter('intermediate_image_sizes_advanced', ['Core\Authors', 'avatar_unset_sizes'], 999, 3);
		add_action('wp_ajax_logout', ['Core\Authors', 'logout']);
		add_filter('wp_nav_menu_items',['Core\Authors','avatar_in_menu'], 10, 2);


		//ADMIN AUTHOR
		add_action('wp_ajax_validateuseremail', ['Core\Authors', 'validateuseremail']);
		add_action('wp_ajax_invalidateuseremail', ['Core\Authors', 'invalidateuseremail']);
		add_action('wp_ajax_makeresident', ['Core\Authors', 'makeresident']);
		add_action('wp_ajax_cancelresident', ['Core\Authors', 'cancelresident']);
	}
	

    static function avatar_in_menu( $nav, $args ) {

		
        if($args->menu->slug == 'personal') {

			$uid = get_current_user_id();

		if($uid > 0) {
		$avaversion = get_the_author_meta( 'avaversion', $uid);
		return str_replace('<a href="#">','<a href="#"><img src="'.get_avatar_url($uid, array('size' => 30,)).'?v='.$avaversion.'">',$nav);
		} else {
		return str_replace('<a href="#">','<a href="#"><img src="'.content_url().'/themes/muzyka21/images/user/avatar.svg">',$nav);
		}

		}

        return $nav;
    }


	//RENAME AVATAR FILE ON UPLOAD
	static function avatar_filenames($filename)
	{
		$info = pathinfo($filename);
		$ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
		return wp_get_current_user()->ID . $ext;
	}
	//UPLOAD FOLDER FILTER FOR AVATAR 
	static function avatar_upload_dir($dirs)
	{
		$dirs['subdir'] = '/avatars';
		$dirs['path'] = $dirs['basedir'] . '/avatars';
		$dirs['url'] = $dirs['baseurl'] . '/avatars';

		return $dirs;
	}

	static function avatar_unset_sizes($sizes, $image_meta)
	{
		
		if (str_contains($image_meta['file'], 'avatars')) {
			error_log('str contains');
			unset($sizes['thumbnail']);
			unset($sizes['medium']);
			unset($sizes['large']);
		}
		// Return sizes you want to create from image (None if image is gif.)
		return $sizes;
	}

	static function valimail($request)
	{
		if ('GET' == $_SERVER['REQUEST_METHOD']) {
			// Verify key / login combo
			$combo = check_password_reset_key($_REQUEST['key'], $_REQUEST['login']);

			if (!$combo || is_wp_error($combo)) {
				if ($combo && $combo->get_error_code() === 'expired_key') {
					wp_redirect(home_url());
				} else {
					wp_redirect(home_url());
				}
				exit;
			}

			$user = get_user_by('login', $_REQUEST['login']);
			$userid = $user->ID;
			flush_rewrite_rules();
			update_user_meta($userid, 'valimail', true);
			wp_redirect(get_author_posts_url($userid));
			exit;
		}
	}


	static function valisend()
	{
		if (wp_verify_nonce($_POST['nonce'], '_vali_send')) {
			$response = array();
			// Get user data by field and data, fields are id, slug, email and login
			$user = wp_get_current_user();

			$user_login = $user->user_login;
			$adt_rp_key = get_password_reset_key($user);
			$rp_link = home_url() . '/wp-json/usermeta/validate/?key=' . $adt_rp_key . '&login=' . rawurlencode($user_login);

			// if  update user return true then lets send user an email containing the new password
			if ($user_login) {

				$from = Init::$techemail; // Set whatever you want like mail@yourdomain.com

				$to = $user->user_email;
				$subject = 'Подтверждение E-MAIL';
				$sender = 'From: MUZYKA XXI <' . $from . '>' . "\r\n";

				$message = '<!DOCTYPE html><html><head><base target="_blank"></head><body><table width="100%" border="0"><td align="center" style="background:#f2f2f2;width:100%"><div id="brand" style="font-size:20px;line-height:80px;text-align:center;color: #d03030;font-weight: 800">MUZYKA XXI</div><div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto"><table width="88%">';
				$message .= '<div id="headerimage" style="width:100%;height:300px;background:url(\'' . content_url() . '/wp-content/themes/asp/images/banners/real-estate-min.jpg\')no-repeat center center;background-size:cover"></div><div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">';
				$message .= '<h2>Подтвердите почту</h2><p>Кто-то пытается подтвердить почту, указанную в профиле на сайте.</p><p>Если это вы, нажмите на кнопку ниже. Если нет - просто проигнорируйте письмо.</p><table height="50" align="center" border="0" cellspacing="0" cellpadding="0" width="100%" style="max-width:360px">';
				$message .= '<td align="center" valign="bottom" height="50" style="padding:0"><a href="' . $rp_link . '" style="display: inline-block; max-width: 360px; width: 100%; font-size: 16px; text-align: center;  text-decoration: none;  color: #333;  padding: 3px 7px;  line-height: 30px; font-weight: 600;  box-shadow: -1px 1px 1px rgba(0,0,0,.25);border-radius: 5px;  background: rgba(0,0,0,.1);  margin-left: 1px;  border-style: initial; cursor: pointer">ПОДТВЕРДИТЬ</a>';
				$message .= '</td></table></div></table></div><table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table></td></table></body></html>';

				$headers[] = 'MIME-Version: 1.0' . "\r\n";
				$headers[] = 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$headers[] = "X-Mailer: PHP \r\n";
				$headers[] = $sender;

				$mail = wp_mail($to, $subject, $message, $headers);
				if ($mail) {
					$response['info'] = 'Письмо отправлено';
					echo json_encode($response);
					die();
				} else {
					$response['info'] = 'Письмо не было отправлено';
					echo json_encode($response);
					die();
				};
			} else {
				$response['info'] = 'Пользователь не найден';
				echo json_encode($response);
				die();
			}
		} else {
			$response['info'] = 'Обновите страницу и попробуйте снова';
			echo json_encode($response);
			die();
		}
	}

	//UPDATE AUTHOR META

	static function updateauth()
	{
		$id = intval($_POST['id']);
		$response = array();
		header('Content-Type: application/json');

		if ($id == wp_get_current_user()->ID && wp_verify_nonce($_POST['nonce'], '_editauthmeta') || current_user_can('editor' || 'administrator')) {
			$meta = sanitize_text_field($_POST['meta']);
			$name = sanitize_text_field($_POST['name']);
			$user = get_userdata($id);

			if ($name == 'display_name') {

				if (strlen($meta) < 50) {
					$args = array(
						'ID'         => $id,
						'display_name' => $meta
					);
					$result = wp_update_user($args);
					if (is_numeric($result)) {
						$response['response'] = "SUCCESS";
						$response['name'] = $name;
						$response['meta'] = $meta;
					} else {
						$response['response'] = "ERROR";
						$response['name'] = $name;
						$response['meta'] = $meta;
						$response['error'] = $result->get_error_message();
					}
				} else {
					$response['response'] = "ERROR";
					$response['name'] = $name;
					$response['meta'] = $meta;
					$response['error'] = 'Только русские буквы и пробелы';
				}
			} else if ($name == 'user_email') {

				if (is_email($meta) && strlen($meta) < 50 && email_exists($meta)) {

					$response['response'] = "ERROR";
					$response['name'] = $name;
					$response['meta'] = $meta;
					$response['error'] = __('This email is already in use', 'muz21');
				} else if (is_email($meta) && strlen($meta) < 50) {

					$args = array(
						'ID'         => $id,
						'user_email' => $meta
					);
					wp_update_user($args);
					update_user_meta($id, 'valimail', false);
					update_user_meta($id, 'xmlhash', hash('md5', $user->ID . $user->user_email));
					$response['response'] = "SUCCESS";
					$response['name'] = $name;
					$response['meta'] = $meta;
				} else {
					$response['response'] = "ERROR";
					$response['name'] = $name;
					$response['meta'] = $meta;
					$response['error'] = 'Формат: email@domain.tld';
				}
			} else if ($name == 'user_phone') {

				if (preg_match("/^\+7[0-9]{10}$/", $meta) && strlen($meta) < 15) {
					update_user_meta($id, 'user_phone', $meta);
					update_user_meta($id, 'valiphone', false);
					$response['response'] = "SUCCESS";
					$response['name'] = $name;
					$response['meta'] = $meta;
				} else {
					$response['response'] = "ERROR";
					$response['name'] = $name;
					$response['meta'] = $meta;
					$response['error'] = 'Формат: +79995555555';
				}
			}
		} else {
			$response['response'] = "ERROR";
			$response['name'] = 'Ошибка безопасности';
			$response['meta'] = 'Ошибка безопасности';
			$response['error'] = 'Ошибка безопасности';
		}
		echo json_encode($response);
		die();
	}


	//AVATAR UPLOAD HANDLER  

	static function updateavatar()
	{
		$id = intval($_POST['id']);
		$response = array();

		if (($id == wp_get_current_user()->ID || current_user_can('editor' || 'administrator')) && wp_verify_nonce($_POST['nonce'], '_editauthmeta')) {

			//Step 1

			if (!function_exists('wp_handle_upload')) {
				require_once(ABSPATH . 'wp-admin/includes/file.php');
			}

			$meta = sanitize_text_field($_POST['meta']);

			$fileErrors = array(
				0 => "There is no error, the file uploaded with success",
				1 => "The uploaded file exceeds the upload_max_files in server settings",
				2 => "The uploaded file exceeds the MAX_FILE_SIZE from html form",
				3 => "The uploaded file uploaded only partially",
				4 => "No file was uploaded",
				6 => "Missing a temporary folder",
				7 => "Failed to write file to disk",
				8 => "A PHP extension stoped file to upload"
			);

			$posted_data =  isset($_POST) ? $_POST : array();
			$file_data = isset($_FILES) ? $_FILES : array();
			header('Content-Type: application/json');
			if ($file_data['file']['type'] == ('image/jpg' || 'image/jpeg' || 'image/png')) {

				$data = array_merge($posted_data, $file_data);

				$curavatar = '/uploads/avatars/' . wp_get_current_user()->ID;

				if (file_exists(ABSPATH . 'wp-content' . $curavatar . '-300x300.jpg')) {
					error_log(content_url() . $curavatar . '-300x300.jpg');
					$attachid = Init::get_image_id(content_url() . $curavatar . '.jpg');
					wp_delete_attachment($attachid, true);
					unlink(ABSPATH . 'wp-content' . $curavatar . '.jpg');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-300x300.jpg');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-60x60.jpg');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-300x300.jpg.webp');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-60x60.jpg.webp');
				} else if (file_exists(ABSPATH . 'wp-content' . $curavatar . '-300x300.png')) {

					$attachid = Init::get_image_id(content_url() . $curavatar . '.png');
					wp_delete_attachment($attachid, true);
					unlink(ABSPATH . 'wp-content' . $curavatar . '.png');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-300x300.png');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-60x60.png');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-300x300.png.webp');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-60x60.png.webp');
				} else if (file_exists(ABSPATH . 'wp-content' . $curavatar . '-300x300.jpeg')) {
					$attachid = Init::get_image_id(content_url() . $curavatar . '.jpeg');
					wp_delete_attachment($attachid, true);
					unlink(ABSPATH . 'wp-content' . $curavatar . '.jpeg');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-300x300.jpeg');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-60x60.jpeg');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-300x300.jpeg.webp');
					unlink(ABSPATH . 'wp-content' . $curavatar . '-60x60.jpeg.webp');
				}

				add_filter('upload_dir', ['Core\Authors', 'avatar_upload_dir']);
				add_filter('sanitize_file_name', ['Core\Authors', 'avatar_filenames']);
				$uploaded_file = wp_handle_upload($data['file'], array('test_form' => false));
				remove_filter('sanitize_file_name', ['Core\Authors', 'avatar_filenames']);
				remove_filter('upload_dir', ['Core\Authors', 'avatar_upload_dir']);

				//Step 2
				if ($uploaded_file && !isset($uploaded_file['error'])) {
					list($width, $height) = getimagesize($uploaded_file['file']);


					if ((intval($height) < 300) || (intval($width) < 300)) {
						$response['response'] = "ERROR";
						$response['error'] = 'Минимум 300 пикселей по ширине и высоте';
						unlink($uploaded_file['file']);
						echo json_encode($response);
						die();
					}

					$attachment = array(
						'guid'           => $uploaded_file['url'],
						'post_mime_type' => $uploaded_file['type'],
						'post_title'     => basename($uploaded_file['url']),
						'post_content'   => '',
						'post_status'    => 'published'
					);

					$attachment_id = wp_insert_attachment($attachment, $uploaded_file['url']); //INSTEAD INSERT AVATAR

					if (is_wp_error($attachment_id)) { //MAYBE REMOVE
						$response['response'] = "ERROR";
						$response['error'] = $attachment_id->get_error_message();
						unlink($uploaded_file['file']);
						echo json_encode($response);
						die();
					} else {
						require_once(ABSPATH . "wp-admin/includes/image.php");

						$attachment_data = wp_generate_attachment_metadata($attachment_id, $uploaded_file['file']);
						wp_update_attachment_metadata($attachment_id,  $attachment_data);
						error_log(print_r($attachment_data, true));
						//UPDATE AVATAR AND DELETE UNUSED SIZES	 

						$avatar = wp_get_attachment_image_src($attachment_id, 'avatar')[0];

						$response['response'] = "SUCCESS";
						$response['thumb'] = $avatar;
						$version = get_user_meta($id, 'avaversion', true);
						if (empty($version)) $version = 0;
						update_user_meta($id, 'avaversion', ++$version);
						$response['version'] = $version;

						$response['details'] = '';
						//END UPDATING AVATAR

					}
				} else {

					$response['response'] = "ERROR";
					$response['error'] = $uploaded_file['error'];
					echo json_encode($response);
					die();
				}

				echo json_encode($response);
				die();
			} else {

				$response['response'] = "ERROR";
				$response['error'] = 'Только .jpg или .png файлы';
				$response['debug'] = $file_data['file']['type'];
				echo json_encode($response);
				die();
			}
		} else {
			$response['response'] = "ERROR";
			$response['error'] = 'Перезагрузите страницу и попробуйте снова';
			echo json_encode($response);
			die();
		}
	}

	//CUSTOM GET AVATAR
	static function avatar($avatar, $id_or_email, $size)
	{
		$user = false;

		if (is_numeric($id_or_email)) {

			$id = (int) $id_or_email;
			$user = get_user_by('id', $id);
		} elseif (is_object($id_or_email)) {

			if (!empty($id_or_email->user_id)) {
				$id = (int) $id_or_email->user_id;
				$user = get_user_by('id', $id);
			}
		} else {
			$user = get_user_by('email', $id_or_email);
		}

		if ($user && is_object($user)) {

			$curavatar = ABSPATH . 'wp-content/uploads/avatars/' . $user->ID;
			$avalink = content_url() . '/uploads/avatars/' . $user->ID;

			if ($size == 30) {
				$sizer = '-60x60';
			} else {
				$sizer = '-300x300';
			};

			if (file_exists($curavatar . '-300x300.jpg')) { //CHECK AVATAR 	
				$avalink = $avalink . $sizer . '.jpg';
				$avatar = "<img src='{$avalink}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
			} else if (file_exists($curavatar . '-300x300.png')) {
				$avalink = $avalink . $sizer . '.png';
				$avatar = "<img src='{$avalink}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
			} else if (file_exists($curavatar . '-300x300.jpeg')) {
				$avalink = $avalink . $sizer . '.jpeg';
				$avatar = "<img src='{$avalink}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
			} else {

				$avalink = content_url() . '/themes/muzyka21/images/user/avatar.svg';
				$avatar = "<img src='{$avalink}' height='{$size}' width='{$size}' />";
			}
		}

		return $avatar;
	}

	//CUSTOM GET AVATAR URL
	static function avatar_url($avatar, $id_or_email, $size)
	{
		$user = false;

		if (is_numeric($id_or_email)) {

			$id = (int) $id_or_email;
			$user = get_user_by('id', $id);
		} elseif (is_object($id_or_email)) {

			if (!empty($id_or_email->user_id)) {
				$id = (int) $id_or_email->user_id;
				$user = get_user_by('id', $id);
			}
		} else {
			$user = get_user_by('email', $id_or_email);
		}

		if ($user && is_object($user)) {

			$curavatar = ABSPATH . 'wp-content/uploads/avatars/' . $user->ID;
			$avalink = content_url() . '/uploads/avatars/' . $user->ID;


			if ($size['size'] == 30) {
				$sizer = '-60x60';
			} else {
				$sizer = '-300x300';
			};

			if (file_exists($curavatar . '-300x300.jpg')) { //CHECK AVATAR 	
				$avatar = $avalink . $sizer . '.jpg';
			} else if (file_exists($curavatar . '-300x300.png')) {
				$avatar = $avalink . $sizer . '.png';
			} else if (file_exists($curavatar . '-300x300.jpeg')) {
				$avatar = $avalink . $sizer . '.jpeg';
			} else {
				$avatar = content_url() . '/themes/muzyka21/images/user/avatar.svg';
			}
		}

		return $avatar;
	}

	//AJAX LOGOUT
	/** Set up the Ajax Logout */
	static function logout()
	{
		$data = array();
		header('Content-Type: application/json');

		if (wp_verify_nonce($_POST['nonce'], '_editauthmeta')) {
			wp_clear_auth_cookie();
			wp_logout();
			ob_clean(); // probably overkill for this, but good habit

			$data['info'] = "SUCCESS";
			echo json_encode($data);
			die();
		} else {
			$data['info'] = 'Ошибка проверки подлинности';
			echo json_encode($data);
			die();
		}
	}

	static function validateuseremail() {
		if(!current_user_can('administrator')) return;
		$aid = intval($_POST['aid']);
		update_user_meta($aid,'valimail',true);
	}
	static function invalidateuseremail() {
		if(!current_user_can('administrator')) return;
		$aid = intval($_POST['aid']);
		update_user_meta($aid,'valimail',false);
	}
	static function makeresident() {
		if(!current_user_can('administrator')) return;
		$aid = intval($_POST['aid']);
		update_user_meta($aid,'resident',true);
	}
	static function cancelresident() {
		if(!current_user_can('administrator')) return;
		$aid = intval($_POST['aid']);
		update_user_meta($aid,'resident',false);
	}
}

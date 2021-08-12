<?php

namespace Core;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class Uploads
{

	public function __construct()
	{
		add_action('wp_ajax_add_attachement_ajax', ['Core\Uploads', 'add_attachement_ajax']);
		add_action('wp_ajax_delete_attachement_ajax', ['Core\Uploads', 'delete_attachement_ajax']);
	}

	public static function custom_unset_images($sizes, $image_meta, $attachment_id)
	{
		unset($sizes['avatar']);
		unset($sizes['mini']);
		return $sizes;
	}

	public static function screenshot_filenames($filename)
	{
		$info = pathinfo($filename);
		$ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
		$name = basename($filename, $ext);
		$date = date('Y-m-d-h-i-s');

		return md5($name . $date) . $ext;
	}

	// Upload new attachement
	public static function add_attachement_ajax()
	{
		header('Content-Type: application/json');
		$postid = intval($_POST['postid']);
		$place = sanitize_text_field($_POST['place']);
		$response = array();

		if (wp_verify_nonce($_POST['nonce'], '_editor')) {


			if (!function_exists('wp_handle_upload')) {
				require_once(ABSPATH . 'wp-admin/includes/file.php');
			}

			$meta = sanitize_text_field($_POST['meta']);
			// 
			// $posttype = '';
			// if (isset($_POST['posttype']))
			// 	$posttype = sanitize_text_field($_POST['posttype']);

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

			if ($file_data['file']['type'] == ('image/jpeg' || 'image/png' || 'image/jpg')) {

				$data = array_merge($posted_data, $file_data);
				add_filter('sanitize_file_name',  ['Core\Uploads','screenshot_filenames']);
				$uploaded_file = wp_handle_upload($data['file'], array('test_form' => false));
				remove_filter('sanitize_file_name',  ['Core\Uploads','screenshot_filenames']);
				//Step 2

				if ($uploaded_file && !isset($uploaded_file['error'])) {
					list($width, $height) = getimagesize($uploaded_file['file']);

					if (($height < 600) || ($width < 974)) {
						$response['response'] = "ERROR";
						$response['error'] = 'минимум 1024x768 пикселей';
						unlink($uploaded_file['file']);
						echo json_encode($response);
						die();
					}

					$attachment = array(
						'guid'           => $uploaded_file['url'],
						'post_mime_type' => $uploaded_file['type'],
						'post_parent'    => $postid,
						'post_title'     => basename($uploaded_file['url']),
						'post_content'   => '',
						'post_status'    => 'inherit'
					);

					$attachment_id = wp_insert_attachment($attachment, $uploaded_file['url'], $id);

					if (is_wp_error($attachment_id)) {
						$response['response'] = "ERROR";
						$response['name'] = $name;
						$response['error'] = $attachment_id->get_error_message();
						unlink($uploaded_file['file']);
						echo json_encode($response);
						die();
					} else {
						require_once(ABSPATH . "wp-admin" . '/includes/image.php');

						add_filter('intermediate_image_sizes_advanced', ['Core\Uploads', 'custom_unset_images'], 999, 3);

						$attachment_data = wp_generate_attachment_metadata($attachment_id, $uploaded_file['file']);
						wp_update_attachment_metadata($attachment_id,  $attachment_data);

						remove_filter('intermediate_image_sizes_advanced', ['Core\Uploads', 'custom_unset_images'], 999);

						//OPTIONALLY SET FEATURED IMAGE
						if ($place == 'featured') set_post_thumbnail($postid, $attachment_id);

						//UPDATE POST THUMBNAIL OR POST META WITH ATTACHEMENT AND DELETE OLD ATTACHEMENT	 

						$thumb = wp_get_attachment_image_src($attachment_id, 'thumbnail')[0];
						$large = wp_get_attachment_image_src($attachment_id, 'large')[0];

						$response['response'] = "SUCCESS";
						$response['thumb'] = $thumb;
						$response['large'] = $large;

						//END UPDATING POST THUMBNAIL OR META

					}
				} else {
					$response['response'] = "ERROR";
					$response['error'] = 'Попробуйте снова';
					echo json_encode($response);
					die();
				}

				//	update_post_meta($id, 'debugf', json_encode($data).json_encode( $response ).json_encode( $_FILES ).json_encode( $_POST ).' '.$height.' '.$width); //DEBUG 	
				if (current_user_can('administrator') == false) {
					$post = array(
						'ID' => $postid,
						'post_status' => 'pending'
					);
					wp_update_post($post);
				}
				echo json_encode($response);
				die();
			} else {

				$response['response'] = "ERROR";
				$response['error'] = 'Только .jpg или .png';
				//	update_post_meta($id, 'debugf', json_encode($file_data).$file_data['file']['type']); //DEBUG 
				echo json_encode($response);
				die();
			}
		} else {
			$response['response'] = "ERROR";
			$response['error'] = 'Обновите страницу';
			echo json_encode($response);
			die();
		}
	}


	public static function delete_attachement_ajax()
	{
		$response = array();
		header('Content-Type: application/json');

		if (wp_verify_nonce($_POST['nonce'], '_editor')) {
			$image = esc_url_raw($_POST['image']);


			$imagefull = preg_replace('/\-[0-9]+x[0-9]+/', '', $image);
			$imagefull = str_replace('.webp', '', $imagefull);
			$id = Init::get_image_id($imagefull);

			$r_thumb = str_replace('https://'.$_SERVER['HTTP_HOST'], ABSPATH, wp_get_attachment_image_src($id, 'thumbnail')[0]);
			$r_medium = str_replace('https://'.$_SERVER['HTTP_HOST'], ABSPATH, wp_get_attachment_image_src($id, 'medium')[0]);
			$r_large = str_replace('https://'.$_SERVER['HTTP_HOST'], ABSPATH, wp_get_attachment_image_src($id, 'large')[0]);
			$r_image_full = str_replace('https://'.$_SERVER['HTTP_HOST'], ABSPATH, $imagefull);

			wp_delete_attachment($id, true);

			try {
				unlink($r_thumb);
				unlink($r_thumb . '.webp');
			} catch (\Exception $e) {
			};

			try {
				unlink($r_medium);
				unlink($r_medium . '.webp');
			} catch (\Exception $e) {
			};

			try {
				unlink($r_large);
				unlink($r_large . '.webp');
			} catch (\Exception $e) {
			};

			try {
				unlink($r_image_full);
				unlink($r_image_full . '.webp');
			} catch (\Exception $e) {
			};


			$response['response'] = "SUCCESS";
			$response['image'] = $image;
			$response['imagefull'] = $imagefull;
			echo json_encode($response);
			die();
		} else {
			$response['response'] = "ERROR";
			$response['error'] = 'Обновите страницу';
			echo json_encode($response);
			die();
		}
	}
}

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php

// Rename screenshot uploads
function screenshot_filenames( $filename ) {
    $info = pathinfo( $filename );
    $ext  = empty( $info['extension'] ) ? '' : '.' . $info['extension'];
    $name = basename( $filename, $ext );
	$date = date('Y-m-d-h-i-s');

    return md5( $name.$date ) . $ext;
}

//PUBLISH PROPERTY HANDLER 
add_action('wp_ajax_change_status_ajax', 'change_status_ajax');
function change_status_ajax() {
	  $id= strip_tags($_POST['id']);
	  $status = strip_tags($_POST['status']);
	  
	  $response = array();
	  header('Content-Type: application/json');
	  
	  if (is_numeric($id) && (wp_verify_nonce( $_POST['nonce'], '_edit_properties') || wp_verify_nonce( $_POST['nonce'], '_edit_blog'))) {
		  
		  //PUBLISH ON SITE
		if ($status == 2) {
				  $my_post = array(
					'ID'           => $id,
					'post_status' => 'publish',
					);
			wp_update_post( $my_post ); 
		
		$type = get_post_type( $id );
		



if ($type == 'property') {
			wp_cache_delete( 'pbg_sitemap_index_props' );
			
		$props = wp_cache_get( 'pbg_sitemap_props_1' );
		if ( false != $props ) {
			$i = 1;
			while ( $i <= $props->max_num_pages ) {
			wp_cache_delete( 'pbg_sitemap_props_'.$i );
			}
		}	

		$pages = wp_cache_get( 'pbg_sitemap_pages_1'  ); //REQUIRES TO BE ADDED TO PAGE PUBLISH INSTEAD
		if ( false != $pages ) {
			$i = 1;
			while ( $i <= $pages->max_num_pages ) {
			wp_cache_delete( 'pbg_sitemap_pages_'.$i );
			}
		}		
}	
	
else if ($type == 'post') {
	
			wp_cache_delete( 'pbg_sitemap_index_blog' );
			wp_cache_delete( 'pbg_sitemap_index_news' );
			
		$blogs = wp_cache_get( 'pbg_sitemap_blog_1'  );
		if ( false != $blogs ) {
			$i = 1;
			while ( $i <= $blogs->max_num_pages ) {
			wp_cache_delete( 'pbg_sitemap_blog_'.$i );
			}
		}
		
		$news = wp_cache_get( 'pbg_sitemap_news_1'  );
		if ( false != $news ) {
			$i = 1;
			while ( $i <= $news->max_num_pages ) {
			wp_cache_delete( 'pbg_sitemap_news_'.$i );
			}
		}
			
}
		

			wp_cache_delete( 'pbg_sitemap_cats' );
			wp_cache_delete( 'pbg_sitemap_tags' );		
			
		$response['response'] = "SUCCESS";
		$response['info'] = 'Опубликовано';
		echo json_encode($response);	
		die();
		} 
		//SAVE AS DRAFT
		else if ($status == 1) {
			$my_post = array(
					'ID'           => $id,
					'post_status' => 'draft',
					);
			wp_update_post( $my_post ); 
		$response['response'] = "SUCCESS";
		$response['info'] = 'Снято с публикации';
		echo json_encode($response);	
		die();
		}
		//DELETE POST
		else if ($status == 3) {
		  $attachments = get_attached_media( '', $id );
			foreach ($attachments as $attachment) {
		
		$r_thumb = str_replace( 'https://media.', '/var/www/new.',wp_get_attachment_image_src( $attachment->ID, 'thumbnail')[0]);	
		$r_medium = str_replace( 'https://media.', '/var/www/new.',wp_get_attachment_image_src( $attachment->ID, 'medium')[0]);
		$r_large = str_replace( 'https://media.', '/var/www/new.',wp_get_attachment_image_src( $attachment->ID, 'large')[0]);		
		$r_image_full = str_replace( 'https://media.', '/var/www/new.', wp_get_attachment_image_src( $attachment->ID, 'full')[0] );
		
		wp_delete_attachment( $attachment->ID, true );
		
		if ($r_thumb) unlink( $r_thumb );
		if ($r_medium) unlink( $r_medium );
		if ($r_large) unlink( $r_large );
		if ($r_image_full) unlink( $r_image_full );
		
		if ($r_thumb) unlink( $r_thumb.'.webp' );
		if ($r_medium) unlink( $r_medium.'.webp' );
		if ($r_large) unlink( $r_large.'.webp' );
		if ($r_image_full) unlink( $r_image_full.'.webp' );
		  }	
		wp_delete_post( $id ); 
		$response['response'] = "SUCCESS";
		$response['info'] = 'Удалено';
		echo json_encode($response);	
		die();
		} 
		//MODERATOR
		else if ($status == 4) {

  $response = array();
 // Get user data by field and data, fields are id, slug, email and login
  $user = wp_get_current_user();
 
  $user_login = $user->user_login;
 
 // if  update user return true then lets send user an email containing the new password
 
 $from = 'no-reply@asp.sale'; // Set whatever you want like mail@yourdomain.com
 
 $to = 'admin@asp.sale';
 $subject = 'ASP: Объект на модерации';
 $sender = 'From: ASP.SALE <'.$from.'>' . "\r\n";
 
	$message = '<!DOCTYPE html><html><head><base target="_blank"></head><body><table width="100%" border="0"><td align="center" style="background:#f2f2f2;width:100%"><div id="brand" style="font-size:20px;line-height:80px;text-align:center;color: #d03030;font-weight: 800">ASP</div><div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto"><table width="88%">';
	$message .= '<div id="headerimage" style="width:100%;height:300px;background:url(\'https://media.asp.sale/wp-content/themes/asp/images/banners/real-estate-min.jpg\')no-repeat center center;background-size:cover"></div><div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">';
	$message .= '<h2>Объект на модерации</h2><p>Объект отправлен на модерацию.</p><p>Перейдите по ссылке, чтобы проверить.</p><table height="50" align="center" border="0" cellspacing="0" cellpadding="0" width="100%" style="max-width:360px">';
	$message .='<td align="center" valign="bottom" height="50" style="padding:0"><a href="https://asp.sale/?preview=true&post_type=property&p='.$id.'" style="display: inline-block; max-width: 360px; width: 100%; font-size: 16px; text-align: center;  text-decoration: none;  color: #333;  padding: 3px 7px;  line-height: 30px; font-weight: 600;  box-shadow: -1px 1px 1px rgba(0,0,0,.25);border-radius: 5px;  background: rgba(0,0,0,.1);  margin-left: 1px;  border-style: initial; cursor: pointer">ПОСМОТРЕТЬ</a>';
	$message .='</td></table></div></table></div><table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table></td></table></body></html>';
 
 $headers[] = 'MIME-Version: 1.0' . "\r\n";
 $headers[] = 'Content-type: text/html; charset=UTF-8' . "\r\n";
 $headers[] = "X-Mailer: PHP \r\n";
 $headers[] = $sender;
 
 $mail = wp_mail( $to, $subject, $message, $headers );
 if( $mail ) {
$response['response'] = "SUCCESS";
 $response['info'] = 'На модерации';
 echo json_encode($response);	
 die();	
 } else {
$response['response'] = "SUCCESS";
 $response['info'] = 'Попробуйте снова'; 
 echo json_encode($response);	
 die();	
 };

}
	}  
	  	$response['response'] = "ERROR";
		$response['error'] = 'Вы что, хакер?'; 
		echo json_encode($response);	
		die();

	}

// Upload new attachement
function add_attachement_ajax(){
	  header('Content-Type: application/json');  
	  $id = strip_tags($_POST['id']);
	  $response = array();

	  if (is_numeric($id) && (wp_verify_nonce( $_POST['nonce'], '_edit_properties') || wp_verify_nonce( $_POST['nonce'], '_edit_blog') || wp_verify_nonce( $_POST['nonce'], '_edit_newsletter')) && is_numeric($_POST['feature']) ) {
	  $feature = strip_tags($_POST['feature']);
		
	  if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}
	  
	  $meta = strip_tags($_POST['meta']);
		
		$posttype = '';
		if (isset($_POST['posttype']))
		$posttype = strip_tags($_POST['posttype']);

	$fileErrors = array(
		0 => "There is no error, the file uploaded with success",
		1 => "The uploaded file exceeds the upload_max_files in server settings",
		2 => "The uploaded file exceeds the MAX_FILE_SIZE from html form",
		3 => "The uploaded file uploaded only partially",
		4 => "No file was uploaded",
		6 => "Missing a temporary folder",
		7 => "Failed to write file to disk",
		8 => "A PHP extension stoped file to upload" );
	
	$posted_data =  isset( $_POST ) ? $_POST : array();
	$file_data = isset( $_FILES ) ? $_FILES : array();
	header('Content-Type: application/json');
	if ($file_data['file']['type'] == ('image/jpeg' || 'image/png' || 'image/jpg')) {	
	
	$data = array_merge( $posted_data, $file_data );
	add_filter( 'sanitize_file_name', 'screenshot_filenames' ); 
	$uploaded_file = wp_handle_upload( $data['file'], array( 'test_form' => false ) );
	remove_filter( 'sanitize_file_name', 'screenshot_filenames' ); 
	//Step 2
	
	if( $uploaded_file && ! isset( $uploaded_file['error'] ) ) {
	list($width, $height) = getimagesize($uploaded_file['file']);
	
	if($posttype == 'post') {

	if (($feature == 1) && ($height < '400px') || ($width < '974px')) {
		$response['response'] = "ERROR";
		$response['error'] = 'минимум 980x400 пикселей';
		unlink( $uploaded_file['file'] );
		echo json_encode( $response );
		die();
	} else if (($feature == 2) && ($height < '600px') || ($width < '974px')) {
		$response['response'] = "ERROR";
		$response['error'] = 'минимум 980x600 пикселей';
		unlink( $uploaded_file['file'] );
		echo json_encode( $response );
		die();

	}

	} else {
	if ($height < '740px' || $width < '740px') {
		$response['response'] = "ERROR";
		$response['error'] = 'минимум 740 пикселей каждая сторона';
		unlink( $uploaded_file['file'] );
		echo json_encode( $response );
		die();
	}
	}
		$attachment = array(
		'guid'           => $uploaded_file['url'], 
		'post_mime_type' => $uploaded_file['type'],
		'post_parent'    => $id,
		'post_title'     => basename( $uploaded_file['url']),
		'post_content'   => '',
		'post_status'    => 'inherit'
		);
 
		$attachment_id = wp_insert_attachment( $attachment, $uploaded_file['url'], $id );
		
	 if ( is_wp_error( $attachment_id ) )  {
		$response['response'] = "ERROR";
		$response['name'] = $name;
		$response['error'] = $attachment_id->get_error_message();
		unlink( $uploaded_file['file'] );
		echo json_encode( $response );
		die();
     } else {
     require_once(ABSPATH . "wp-admin" . '/includes/image.php');
 
     $attachment_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
     wp_update_attachment_metadata( $attachment_id,  $attachment_data );
	 
	 //OPTIONALLY SET FEATURED IMAGE
	 if($feature == 2) set_post_thumbnail( $id, $attachment_id );
	 
//UPDATE POST THUMBNAIL OR POST META WITH ATTACHEMENT AND DELETE OLD ATTACHEMENT	 
		
		$thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail')[0];
		$ava = wp_get_attachment_image_src( $attachment_id, 'avatar')[0];
		$mini = wp_get_attachment_image_src( $attachment_id, 'mini')[0];
		$large = wp_get_attachment_image_src( $attachment_id, 'large')[0];
		
		$r_ava = str_replace( 'https://media.', '/var/www/new.', $ava );
		$r_mini = str_replace( 'https://media.', '/var/www/new.', $mini );
		
		$avad = attachment_url_to_postid($ava);	
		$minid = attachment_url_to_postid($mini);	
		
		wp_delete_attachment( $avad, true );
		wp_delete_attachment( $minid, true );
		
		if ($r_ava) unlink( $r_ava );
		if ($r_mini) unlink( $r_mini );
		
		$response['response'] = "SUCCESS";
		$response['thumb'] = $thumb;
		$response['large'] = $large;
		
//END UPDATING POST THUMBNAIL OR META

	 }} else {
		$response['response'] = "ERROR";
		$response['error'] = 'Попробуйте снова';
		echo json_encode($response);	
		die();	
	}
	
//	update_post_meta($id, 'debugf', json_encode($data).json_encode( $response ).json_encode( $_FILES ).json_encode( $_POST ).' '.$height.' '.$width); //DEBUG 	
	if(current_user_can('administrator') == false) {
	$post = array(
		'ID' => $id,
		'post_status' => 'pending'
	);
	wp_update_post( $post );
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

add_action('wp_ajax_add_attachement_ajax', 'add_attachement_ajax');

function delete_attachement_ajax() {
		$response = array();
		header('Content-Type: application/json');  
	
		if (wp_verify_nonce( $_POST['nonce'], '_edit_properties') || wp_verify_nonce( $_POST['nonce'], '_edit_blog') || wp_verify_nonce( $_POST['nonce'], '_edit_newsletter')) {
		$image = esc_url_raw($_POST['image']);

		
		$imagefull = preg_replace('/\-[0-9]+x[0-9]+/','',$image);
		$imagefull = str_replace('.webp','',$imagefull);
		$id = asp_get_image_id($imagefull);	

		$r_thumb = str_replace( 'https://media.', '/var/www/new.',wp_get_attachment_image_src( $id, 'thumbnail')[0]);	
		$r_medium = str_replace( 'https://media.', '/var/www/new.',wp_get_attachment_image_src( $id, 'medium')[0]);
		$r_large = str_replace( 'https://media.', '/var/www/new.',wp_get_attachment_image_src( $id, 'large')[0]);		
		$r_image_full = str_replace( 'https://media.', '/var/www/new.', $imagefull );
		
		wp_delete_attachment( $id, true );
		
		try {  
		unlink( $r_thumb ); 
		unlink ($r_thumb.'.webp');
		} catch(Exception $e) {
			
		};

		try {  
		unlink( $r_medium ); 
		unlink ($r_medium.'.webp');
		} catch(Exception $e) {
			
		};
		
		try {  
		unlink( $r_large ); 
		unlink ($r_large.'.webp');
		} catch(Exception $e) {
			
		};
		
		try {  
		unlink( $r_image_full ); 
		unlink ($r_image_full.'.webp');
		} catch(Exception $e) {
			
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
add_action('wp_ajax_delete_attachement_ajax', 'delete_attachement_ajax');


function update_props_content_ajax() {
		$response = array();
		header('Content-Type: application/json');
		
		if(!is_numeric($_POST['id'])) {
		$response['response'] = "ERROR";
		$response['error'] = 'Неверные данные'; 
		echo json_encode($response);	
		die();		
		} else {
			$id = $_POST['id'];
		}
		
		if (wp_verify_nonce( $_POST['nonce'], '_edit_properties')) {
	    $content = wp_kses_post( strip_tags($_POST['content'], "<h3><p><li>"));
		
		$my_post = array(
		'ID'           => $id,
		'post_content'   => $content,
		);
		wp_update_post( $my_post ); 
		

			
		$response['response'] = "SUCCESS";
		echo json_encode($response);
		die();
		} else {	
		$response['response'] = "ERROR";
		$response['error'] = 'Обновите страницу'; 
		echo json_encode($response);	
		die();		
		}
}
add_action('wp_ajax_update_props_content_ajax', 'update_props_content_ajax');

function update_blog_content_ajax() {
		$response = array();
		header('Content-Type: application/json');
		
		if(!is_numeric($_POST['id'])) {
		$response['response'] = "ERROR";
		$response['error'] = 'Неверные данные'; 
		echo json_encode($response);	
		die();		
		} else {
			$id = $_POST['id'];
		}
		
		if (wp_verify_nonce( $_POST['nonce'], '_edit_blog')) {
	    $content = wp_kses_post( strip_tags($_POST['content'], "<h2><h3><h4><p><li><img>"));
		
		$my_post = array(
		'ID'           => $id,
		'post_content'   => $content,
		);
		wp_update_post( $my_post ); 
		$response['response'] = "SUCCESS";
		echo json_encode($response);
		die();
		} else {	
		$response['response'] = "ERROR";
		$response['error'] = 'Обновите страницу'; 
		echo json_encode($response);	
		die();		
		}
}
add_action('wp_ajax_update_blog_content_ajax', 'update_blog_content_ajax');

function update_newsletter_content_ajax() {
		$response = array();
		header('Content-Type: application/json');
		
		if(!is_numeric($_POST['id'])) {
		$response['response'] = "ERROR";
		$response['error'] = 'Неверные данные'; 
		echo json_encode($response);	
		die();		
		} else {
			$id = $_POST['id'];
		}
		
		if (wp_verify_nonce( $_POST['nonce'], '_edit_newsletter')) {
	    $content = wp_kses_post( strip_tags($_POST['content'], "<h3><p><li><img>"));
		
		$my_post = array(
		'ID'           => $id,
		'post_content'   => $content,
		);
		wp_update_post( $my_post ); 
		$response['response'] = "SUCCESS";
		echo json_encode($response);
		die();
		} else {	
		$response['response'] = "ERROR";
		$response['error'] = 'Обновите страницу'; 
		echo json_encode($response);	
		die();
		}
}
add_action('wp_ajax_update_newsletter_content_ajax', 'update_newsletter_content_ajax');
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php
function ajax_auth_init(){	

    wp_localize_script( 'ajax-auth-script', 'ajax_auth_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajax_login', 'ajax_login' );
	
	// Enable the user with no privileges to run ajax_register() in AJAX
	add_action( 'wp_ajax_nopriv_ajax_register', 'ajax_register' );
	
	// Recovery link
	add_action( 'wp_ajax_nopriv_ajax_forgotpassword', 'ajax_forgotpassword' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_auth_init');
}
  
function ajax_login(){

if (
//check_ajax_referer( '_log_user', 'nonce' )
wp_verify_nonce( $_POST['nonce'], '_log_user')
) {
	
	auth_user_login($_POST['username'], $_POST['password'], 'Login'); 
	
} 
    die();
}

function ajax_register(){
	$response = array();
	
	if (wp_verify_nonce( $_POST['nonce'], '_reg_user')) { 

	header('Content-Type: application/json');	
    $info = array();
	$userfrommail = preg_replace('/@.+/i','',$_POST['email']);
  	$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($userfrommail);
    $info['user_pass'] = sanitize_text_field($_POST['password']);
	$info['user_email'] = sanitize_email($_POST['email']);
	$phone = sanitize_text_field( $_POST['phone']);
	
	if (preg_match("/^\+7[0-9]{10}$/", $phone) == false ) {
		
					$response['response'] = "ERROR";
					$response['loggedin'] = false;
					$response['message'] = "Неверный формат телефона";
					echo json_encode( $response );
					die();
	}

	$i = 1;
	if (username_exists($info['user_login']) != false) {
	while(username_exists($info['user_login']) != false) {
		$info['user_login'] = sanitize_user($userfrommail).$i;
		$info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'];
		$i++;
	}};
		
	// Register the user
    $user_register = wp_insert_user( $info );
 	if ( is_wp_error($user_register) ){	
		$error  = $user_register->get_error_codes()	;
		
		if(in_array('empty_user_login', $error)) {
			        $response['response'] = "ERROR";
					$response['loggedin'] = false;
					$response['message'] = "Укажите имя пользователя";
					echo json_encode( $response );
					die();
		} elseif(in_array('existing_user_login',$error)) {
					$response['response'] = "ERROR";
					$response['loggedin'] = false;
					$response['message'] = "Имя пользователя занято";
					echo json_encode( $response );
					die();
			
		} elseif(in_array('existing_user_email',$error)) {
					$response['response'] = "ERROR";
					$response['loggedin'] = false;
					$response['message'] = "Адрес почты уже используется";
					echo json_encode( $response );
					die();
		}
    } else {
	  $user = get_userdata( $user_register );
	  update_user_meta( $user_register, 'user_phone', $phone );
	  update_user_meta( $user_register,'xmlhash',hash('md5',$user->ID.$user->user_email));
	  auth_user_login($info['nickname'], $info['user_pass'], 'Registration');   
    }

    die();
	}
}

function ajax_forgotpassword(){
 
 // First check the nonce, if it fails the function will break
 //   check_ajax_referer( '_lost_pass', 'nonce' );
	
	if (wp_verify_nonce( $_POST['nonce'], '_lost_pass')) {
 
 global $wpdb;
 
 $account = $_POST['username'];
 
 if( empty( $account ) ) {
 $error = 'Enter an username or e-mail address.';
 } else {
 if(is_email( $account )) {
 if( email_exists($account) ) 
 $get_by = 'email';
 else 
 $error = 'Аккаунт с таким адресом почты не зарегистрирован.'; 
 }
 else if (validate_username( $account )) {
 if( username_exists($account) ) 
 $get_by = 'login';
 else 
 $error = 'Аккаунт с таким логином не зарегистрирован.'; 
 }
 else
 $error = 'Неверный логин или адрес почты.'; 
 } 
 
 if(empty ($error)) {
 // lets generate our new password
 //$random_password = wp_generate_password( 12, false );
// $random_password = wp_generate_password();
 
 
 // Get user data by field and data, fields are id, slug, email and login
 $user = get_user_by( $get_by, $account );
 
 //$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );
 
  $user_login = $user->user_login;
  $adt_rp_key = get_password_reset_key( $user );
  $rp_link = wp_login_url().'?action=rp&key='.$adt_rp_key.'&login='.rawurlencode($user_login);
 
 // if  update user return true then lets send user an email containing the new password
 if( $user_login ) {
 
 $from = 'no-reply@asp.sale'; // Set whatever you want like mail@yourdomain.com
 
 $to = $user->user_email;
 $subject = 'ASP: Восстановление Пароля';
 $sender = 'From: ASP <'.$from.'>' . "\r\n";
 
	$message = '<!DOCTYPE html><html><head><base target="_blank"></head><body><table width="100%" border="0"><td align="center" style="background:#f2f2f2;width:100%"><div id="brand" style="font-size:20px;line-height:80px;text-align:center;color: #d03030;font-weight: 800">ASP</div><div id="emailcontainer" style="width:100%;max-width:600px;background:#fff;padding:30px 0;margin:auto"><table width="88%">';
	$message .= '<div id="headerimage" style="width:100%;height:300px;background:url(\'https://media.asp.sale/wp-content/themes/asp/images/banners/real-estate-min.jpg\')no-repeat center center;background-size:cover"></div><div id="contentstuff" style="padding: 0px 15px 15px 15px;text-align:justify">';
	$message .= '<h2>Восстановление Пароля</h2><p>Кто-то запросил новый пароль для аккаунта привязанного к этой почте.</p><p>Если это были вы - нажмите на кнопку ниже, чтобы создать новый пароль. Если это были не вы - просто проигнорируйте это сообщение.</p><table height="50" align="center" border="0" cellspacing="0" cellpadding="0" width="100%" style="max-width:360px">';
	$message .='<td align="center" valign="bottom" height="50" style="padding:0"><a href="'.$rp_link.'" style="display: inline-block; max-width: 360px; width: 100%; font-size: 16px; text-align: center;  text-decoration: none;  border: 1px solid #e0e0e0;color: #d03030;  padding: 3px 7px;  line-height: 30px; font-weight: 600;  box-shadow: -1px 1px 1px rgba(0,0,0,.25);border-radius: 5px;  background: #fff;  margin-left: 1px; cursor: pointer">Сбросить Пароль</a>';
	$message .='</td></table></div></table></div><table style="font-size:12px;line-height:80px;text-align:center;color:#444;height:80px"></table></td></table></body></html>';
 
 $headers[] = 'MIME-Version: 1.0' . "\r\n";
 $headers[] = 'Content-type: text/html; charset=UTF-8' . "\r\n";
 $headers[] = "X-Mailer: PHP \r\n";
 $headers[] = $sender;
 
 $mail = wp_mail( $to, $subject, $message, $headers );
 if( $mail ) 
 $success = 'Проверьте вашу почту, письмо может идти пару минут, и может попасть в спам.';
 else
 $error = 'Мы не смогли отправить вам ссылку на сброс пароля, попробуйте снова.'; 
 } else {
 $error = 'Похоже это какая-то неизвестная ошибка, обратитесь к админам.';
 }
 }
 
 if( ! empty( $error ) )
 echo json_encode(array('loggedin'=>false, 'message'=>__($error)));
 
 if( ! empty( $success ) )
 echo json_encode(array('loggedin'=>false, 'message'=>__($success)));

	}
 die();
}

function auth_user_login($user_login, $password, $login)
{
	
	$info = array();
    $info['user_login'] = $user_login;
    $info['user_password'] = $password;
    $info['remember'] = true;
	header('Content-Type: application/json');	
	$response = array();
	$user_signon = wp_signon( $info, '' ); // From false to '' since v4.9
	
    if ( is_wp_error($user_signon) ){
        $response['response'] = "ERROR";
		$response['loggedin'] = false;
		$response['message'] = 'Вход не удался. Если вы не помните пароль, вы можете его восстановить!';
        echo json_encode( $response );
		die();
    } else {
		wp_set_current_user($user_signon->ID); 
        $response['response'] = "SUCCESS";
		$response['loggedin'] = true;
		$response['id'] = wp_get_current_user()->user_nicename;
		$response['message'] = __('Вы вошли, подождите...');
        echo json_encode( $response );
		die();
    }
}

/**
 * Redirects to the custom password reset page, or the login page
 * if there are errors.
 */
add_action( 'login_form_rp', 'redirect_to_custom_password_reset' );
add_action( 'login_form_resetpass', 'redirect_to_custom_password_reset' );

add_action( 'login_form_rp', 'do_password_reset' );
add_action( 'login_form_resetpass', 'do_password_reset' );

function redirect_to_custom_password_reset() {
    if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
        // Verify key / login combo
        $user = check_password_reset_key( $_REQUEST['key'], $_REQUEST['login'] );
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( home_url( 'reset-pass?login=expiredkey' ) );
            } else {
                wp_redirect( home_url( 'reset-pass?login=invalidkey' ) );
            }
            exit;
        }
 
        $redirect_url = home_url( 'reset-pass' );
        $redirect_url = add_query_arg( 'login', esc_attr( $_REQUEST['login'] ), $redirect_url );
        $redirect_url = add_query_arg( 'key', esc_attr( $_REQUEST['key'] ), $redirect_url );
 
        wp_redirect( $redirect_url );
        exit;
    }
}

add_shortcode( 'custom-password-reset-form', 'render_password_reset_form' );

/**
 * A shortcode for rendering the form used to reset a user's password.
 *
 * @param  array   $attributes  Shortcode attributes.
 * @param  string  $content     The text content for shortcode. Not used.
 *
 * @return string  The shortcode output
 */
function render_password_reset_form( $attributes, $content = null ) {
    // Parse shortcode attributes
    $default_attributes = array( 'show_title' => false );
    $attributes = shortcode_atts( $default_attributes, $attributes );
 
    if ( is_user_logged_in() ) {
        get_template_part( 'password_reset_form' );
    } else {
        if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
            $attributes['login'] = $_REQUEST['login'];
            $attributes['key'] = $_REQUEST['key'];
 
            // Error messages
            $errors = array();
            if ( isset( $_REQUEST['error'] ) ) {
                $error_codes = explode( ',', $_REQUEST['error'] );
 
                foreach ( $error_codes as $code ) {
                    $errors []= $this->get_error_message( $code );
                }
            }
            $attributes['errors'] = $errors;
			
          //  return get_template_html( 'password_reset_form', $attributes );
			get_template_part( 'password_reset_form' );
        } else {
            get_template_part( 'password_reset_form' );
        }
    }
}

/**
 * Resets the user's password if the password reset form was submitted.
 */
function do_password_reset() {
    if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
        $rp_key = $_REQUEST['rp_key'];
        $rp_login = $_REQUEST['rp_login'];
 
        $user = check_password_reset_key( $rp_key, $rp_login );
 
        if ( ! $user || is_wp_error( $user ) ) {
            if ( $user && $user->get_error_code() === 'expired_key' ) {
                wp_redirect( home_url( 'reset-password?login=invalidkey' ) );
            } else {
                wp_redirect( home_url( 'reset-password?login=invalidkey' ) );
            }
            exit;
        }
 
        if ( isset( $_POST['pass1'] ) ) {
            if ( $_POST['pass1'] != $_POST['pass2'] ) {
                // Passwords don't match
                $redirect_url = home_url( 'reset-password' );
 
                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );
 
                wp_redirect( $redirect_url );
                exit;
            }
 
            if ( empty( $_POST['pass1'] ) ) {
                // Password is empty
                $redirect_url = home_url( 'reset-password' );
 
                $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );
 
                wp_redirect( $redirect_url );
                exit;
            }
 
            // Parameter checks OK, reset password
            reset_password( $user, $_POST['pass1'] );
            wp_redirect( home_url( '?password=changed' ) );
        } else {
            echo "Ошибка в запросе.";
        }
 
        exit;
    }
}
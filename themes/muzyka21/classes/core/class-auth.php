<?php
namespace Core;
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class Auth
{

    public function __construct()
    {
        if (!is_user_logged_in()) {
            add_action('init', ['Core\Auth', 'ajax_auth_init']);
        }
    }

    static function ajax_auth_init()
    {
        // Enable the user with no privileges to run ajax_login() in AJAX
        add_action('wp_ajax_nopriv_ajax_login', ['Core\Auth', 'ajax_login']);

        // Enable the user with no privileges to run ajax_register() in AJAX
        add_action('wp_ajax_nopriv_ajax_register', ['Core\Auth', 'ajax_register']);

        // Recovery link
        add_action('wp_ajax_nopriv_ajax_forgotpassword', ['Core\Auth', 'ajax_forgotpassword']);

        add_action('login_form_rp', ['Core\Auth', 'redirect_to_custom_password_reset']);
        add_action('login_form_resetpass', ['Core\Auth', 'redirect_to_custom_password_reset']);

        add_action('login_form_rp', ['Core\Auth', 'do_password_reset']);
        add_action('login_form_resetpass', ['Core\Auth', 'do_password_reset']);

        
        add_shortcode('custom-password-reset-form', ['Core\Auth', 'render_password_reset_form']);

        wp_localize_script('ajax-auth-script', 'ajax_auth_object', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'redirecturl' => home_url(),
            'loadingmessage' => __('Sending user info, please wait...')
        ));
    }

    // Execute the action only if the user isn't logged in


    static function ajax_login()
    {

        if (
            wp_verify_nonce($_POST['nonce'], '_regforms')
        ) {

            Auth::auth_user_login($_POST['username'], $_POST['password'], 'Login');
        }
        die();
    }

    static function ajax_register()
    {
        $response = array();

        if (wp_verify_nonce($_POST['nonce'], '_regforms')) {

            header('Content-Type: application/json');
            $info = array();
            $userfrommail = preg_replace('/@.+/i', '', $_POST['email']);
            $info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'] = sanitize_user($userfrommail);
            $info['user_pass'] = sanitize_text_field($_POST['password']);
            $info['user_email'] = sanitize_email($_POST['email']);
            $phone = sanitize_text_field($_POST['phone']);

            if (preg_match("/^\+7[0-9]{10}$/", $phone) == false) {

                $response['response'] = "ERROR";
                $response['loggedin'] = false;
                $response['message'] = "Неверный формат телефона";
                echo json_encode($response);
                die();
            }

            $i = 1;
            if (username_exists($info['user_login']) != false) {
                while (username_exists($info['user_login']) != false) {
                    $info['user_login'] = sanitize_user($userfrommail) . $i;
                    $info['user_nicename'] = $info['nickname'] = $info['display_name'] = $info['first_name'] = $info['user_login'];
                    $i++;
                }
            };

            // Register the user
            $user_register = wp_insert_user($info);
            if (is_wp_error($user_register)) {
                $error  = $user_register->get_error_codes();

                if (in_array('empty_user_login', $error)) {
                    $response['response'] = "ERROR";
                    $response['loggedin'] = false;
                    $response['message'] = "Укажите имя пользователя";
                    echo json_encode($response);
                    die();
                } elseif (in_array('existing_user_login', $error)) {
                    $response['response'] = "ERROR";
                    $response['loggedin'] = false;
                    $response['message'] = "Имя пользователя занято";
                    echo json_encode($response);
                    die();
                } elseif (in_array('existing_user_email', $error)) {
                    $response['response'] = "ERROR";
                    $response['loggedin'] = false;
                    $response['message'] = "Адрес почты уже используется";
                    echo json_encode($response);
                    die();
                }
            } else {
                $user = get_userdata($user_register);
                update_user_meta($user_register, 'user_phone', $phone);
                update_user_meta($user_register, 'xmlhash', hash('md5', $user->ID . $user->user_email));
                Auth::auth_user_login($info['nickname'], $info['user_pass'], 'Registration');
            }

            die();
        }
    }

    static function ajax_forgotpassword()
    {

        // First check the nonce, if it fails the function will break
        //   check_ajax_referer( '_lost_pass', 'nonce' );

        if (wp_verify_nonce($_POST['nonce'], '_regforms')) {

            global $wpdb;

            $account = $_POST['username'];

            if (empty($account)) {
                $error = 'Enter an username or e-mail address.';
            } else {
                if (is_email($account)) {
                    if (email_exists($account))
                        $get_by = 'email';
                    else
                        $error = 'Аккаунт с таким адресом почты не зарегистрирован.';
                } else if (validate_username($account)) {
                    if (username_exists($account))
                        $get_by = 'login';
                    else
                        $error = 'Аккаунт с таким логином не зарегистрирован.';
                } else
                    $error = 'Неверный логин или адрес почты.';
            }

            if (empty($error)) {
                // lets generate our new password
                //$random_password = wp_generate_password( 12, false );
                // $random_password = wp_generate_password();


                // Get user data by field and data, fields are id, slug, email and login
                $user = get_user_by($get_by, $account);

                //$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );

                $user_login = $user->user_login;
                $adt_rp_key = get_password_reset_key($user);
                $rp_link = wp_login_url() . '?action=rp&key=' . $adt_rp_key . '&login=' . rawurlencode($user_login);

                // if  update user return true then lets send user an email containing the new password
                if ($user_login) {


                    $emailargs = array(
                        'to' => $user->user_email,
                        'subject' => 'MUSIC XXI: Восстановление Пароля',
                        'rp_link' => $rp_link
                    );
                    $result = Emails::sendEmail('forgotpassword',$emailargs);

                } else {
                    $result['status'] = 'error';
                    $result['message'] = 'Похоже это какая-то неизвестная ошибка, обратитесь к админам.';
                }
            }

            echo json_encode(array('loggedin' => false, 'message' => $result['message']));

        }
        die();
    }

    static function auth_user_login($user_login, $password, $login)
    {

        $info = array();
        $info['user_login'] = $user_login;
        $info['user_password'] = $password;
        $info['remember'] = true;
        header('Content-Type: application/json');
        $response = array();
        $user_signon = wp_signon($info, ''); // From false to '' since v4.9

        if (is_wp_error($user_signon)) {
            $response['response'] = "ERROR";
            $response['loggedin'] = false;
            $response['message'] = 'Вход не удался. Если вы не помните пароль, вы можете его восстановить!';
            echo json_encode($response);
            die();
        } else {
            wp_set_current_user($user_signon->ID);
            $response['response'] = "SUCCESS";
            $response['loggedin'] = true;
            $response['id'] = wp_get_current_user()->user_nicename;
            $response['message'] = __('Вы вошли, подождите...');
            echo json_encode($response);
            die();
        }
    }

    /**
     * Redirects to the custom password reset page, or the login page
     * if there are errors.
     */


    static function redirect_to_custom_password_reset()
    {
        if ('GET' == $_SERVER['REQUEST_METHOD']) {
            // Verify key / login combo
            $user = check_password_reset_key($_REQUEST['key'], $_REQUEST['login']);
            if (!$user || is_wp_error($user)) {
                if ($user && $user->get_error_code() === 'expired_key') {
                    wp_redirect(home_url('reset-pass?login=expiredkey'));
                } else {
                    wp_redirect(home_url('reset-pass?login=invalidkey'));
                }
                exit;
            }

            $redirect_url = home_url('reset-pass');
            $redirect_url = add_query_arg('login', esc_attr($_REQUEST['login']), $redirect_url);
            $redirect_url = add_query_arg('key', esc_attr($_REQUEST['key']), $redirect_url);

            wp_redirect($redirect_url);
            exit;
        }
    }



    /**
     * A shortcode for rendering the form used to reset a user's password.
     *
     * @param  array   $attributes  Shortcode attributes.
     * @param  string  $content     The text content for shortcode. Not used.
     *
     * @return string  The shortcode output
     */
    static function render_password_reset_form($attributes, $content = null)
    {
        // Parse shortcode attributes
        $default_attributes = array('show_title' => false);
        $attributes = shortcode_atts($default_attributes, $attributes);

        if (is_user_logged_in()) {
            get_template_part('password_reset_form');
        } else {
            if (isset($_REQUEST['login']) && isset($_REQUEST['key'])) {
                $attributes['login'] = $_REQUEST['login'];
                $attributes['key'] = $_REQUEST['key'];

                // Error messages
                $errors = array();
                if (isset($_REQUEST['error'])) {
                    $error_codes = explode(',', $_REQUEST['error']);

                    foreach ($error_codes as $code) {
                        $errors[] = $code; //$this->get_error_message($code);
                    }
                }
                $attributes['errors'] = $errors;

                //  return get_template_html( 'password_reset_form', $attributes );
                get_template_part('password_reset_form');
            } else {
                get_template_part('password_reset_form');
            }
        }
    }

    /**
     * Resets the user's password if the password reset form was submitted.
     */
    static function do_password_reset()
    {
        if ('POST' == $_SERVER['REQUEST_METHOD']) {
            $rp_key = $_REQUEST['rp_key'];
            $rp_login = $_REQUEST['rp_login'];

            $user = check_password_reset_key($rp_key, $rp_login);

            if (!$user || is_wp_error($user)) {
                if ($user && $user->get_error_code() === 'expired_key') {
                    wp_redirect(home_url('reset-password?login=invalidkey'));
                } else {
                    wp_redirect(home_url('reset-password?login=invalidkey'));
                }
                exit;
            }

            if (isset($_POST['pass1'])) {
                if ($_POST['pass1'] != $_POST['pass2']) {
                    // Passwords don't match
                    $redirect_url = home_url('reset-password');

                    $redirect_url = add_query_arg('key', $rp_key, $redirect_url);
                    $redirect_url = add_query_arg('login', $rp_login, $redirect_url);
                    $redirect_url = add_query_arg('error', 'password_reset_mismatch', $redirect_url);

                    wp_redirect($redirect_url);
                    exit;
                }

                if (empty($_POST['pass1'])) {
                    // Password is empty
                    $redirect_url = home_url('reset-password');

                    $redirect_url = add_query_arg('key', $rp_key, $redirect_url);
                    $redirect_url = add_query_arg('login', $rp_login, $redirect_url);
                    $redirect_url = add_query_arg('error', 'password_reset_empty', $redirect_url);

                    wp_redirect($redirect_url);
                    exit;
                }

                // Parameter checks OK, reset password
                reset_password($user, $_POST['pass1']);
                wp_redirect(home_url('?password=changed'));
            } else {
                echo "Ошибка в запросе.";
            }

            exit;
        }
    }
}

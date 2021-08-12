<?php

namespace Core;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class Emails
{

    public static function sendEmail(string $templatename, array $args) {

        $from = Init::$techemail;
        $sender = 'From: MUSIC XXI <' . $from . '>' . "\r\n";
        $to = $args['to'];
        $subject = $args['subject'];
        $headers[] = 'MIME-Version: 1.0' . "\r\n";
        $headers[] = 'Content-type: text/html; charset=UTF-8' . "\r\n";
        $headers[] = "X-Mailer: PHP \r\n";
        $headers[] = $sender;


        ob_start();
        get_template_part( 'templates/emails/'.$templatename, null, $args);
        $message = ob_get_contents();
        ob_end_clean();

        $mail = wp_mail($to, $subject, $message, $headers);

    }


}
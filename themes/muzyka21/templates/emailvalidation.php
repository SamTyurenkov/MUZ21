<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
} 
$uid = wp_get_current_user()->ID; 
$translations = get_field('email_validation','option');
?>

    <form class="emailvalidation-form" action="valisend" method="post" style="max-width:100%;width:600px;padding-top:60px;text-align:center;margin:0 auto">
        <div>
            <div>
            <?php echo $translations['text']; ?>
            </div>
            <?php wp_nonce_field('_vali_send', '_vali_send'); ?>

            <div class="button" id="valisend" type="submit" name="valisend"><?php echo esc_html($translations['button_text']); ?></div>
            <div id="validation" style="padding: 20px;color: #d03030"></div>
        </div>
    </form>

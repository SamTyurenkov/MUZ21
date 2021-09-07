<?php if (is_singular('events') || is_singular('services')) : ?>
    <div class="prepayment-frame">
		<?php wp_nonce_field('_payments', '_payments'); ?>
        <div class="prepayment-frame_customer_details">
            <span class="button close closepayframe" style="right: 0;position: absolute;    top: 0;padding: 3px 7px;z-index:15">X</span>
            <span class="input_container input_large">
            <h2><?php echo get_field('payment_frame_title','option'); ?></h2>
            <p><?php echo get_field('payment_frame_subtitle','option'); ?></p>
            </span>
            <span class="input_container input_large">
                <label><?php echo esc_attr(get_field('contact_form_email_text', 'option')); ?></label>
                <input class="form_email" required type="email" value="<?php if(get_current_user_id() > 0)  echo esc_attr(get_the_author_meta('email', get_current_user_id())); ?>"></input>
            </span>
            <span class="input_container">
                <label><?php echo esc_attr(get_field('contact_form_name_text', 'option')); ?></label>
                <input class="form_name" required type="text" value="<?php if(get_current_user_id() > 0)  echo esc_attr(get_the_author_meta('display_name', get_current_user_id())); ?>"></input>
            </span>
            <span class="input_container">
                <label><?php echo esc_attr(get_field('contact_form_phone_text', 'option')); ?></label>
                <input class="form_phone" required type="text" value="<?php if(get_current_user_id() > 0) echo esc_attr(get_the_author_meta('user_phone', get_current_user_id())); ?>"></input>
            </span>
            <span class="input_container input_large form_title">

            </span>
            <span class="input_container input_large form_price">

            </span>
            <input class="order_id" type="hidden" value=""></input>
            <input class="form_page" type="hidden" value="<?php echo esc_attr(get_permalink()); ?>"></input>
            <input type="submit" class="button" value="<?php echo esc_attr(get_field('payment_frame_submit', 'option')); ?>">
        </div>


    </div>
    <?php 
    $payform = array();
    if(str_contains(home_url(),'musicspb21.ru')) {
        $payform = array('https://pay2.alfabank.ru/assets/alfa-payment.js','3mvqe2ispthavmh2tqdfojd5d');
    } else {
        $payform = array('https://testpay.alfabank.ru/assets/alfa-payment.js','r3u3ps5om0uq8j7c2tjj1pjicq');
    }
    
    
    ?>
    <div id="alfa-payment-button" data-amount='.event-price_flex_price_value span' data-description-selector='.form_title' data-order-number-selector='.order_id' data-version='1.0' data-stages='1' data-amount-format='rubli' data-email-selector='.form_email' data-client-info-selector='.form_email' data-token='<?php echo esc_attr($payform[1]); ?>' data-language-selector='<?php echo esc_attr(ICL_LANGUAGE_CODE); ?>'></div>
    <script id="alfa-payment-script" type="text/javascript" src="<?php echo esc_attr($payform[0]); ?>">
    </script>
<?php endif; ?>
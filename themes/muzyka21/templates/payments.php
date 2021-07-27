<?php if (is_singular('events')) : ?>
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
                <input class="form_email" required type="email" value="<?php echo esc_attr(get_the_author_meta('email', get_current_user_id())); ?>"></input>
            </span>
            <span class="input_container">
                <label><?php echo esc_attr(get_field('contact_form_name_text', 'option')); ?></label>
                <input class="form_name" required type="text" value="<?php echo esc_attr(get_the_author_meta('display_name', get_current_user_id())); ?>"></input>
            </span>
            <span class="input_container">
                <label><?php echo esc_attr(get_field('contact_form_phone_text', 'option')); ?></label>
                <input class="form_phone" required type="text" value="<?php echo esc_attr(get_the_author_meta('user_phone', get_current_user_id())); ?>"></input>
            </span>
            <span class="input_container input_large form_title">

            </span>
            <span class="input_container input_large form_price">

            </span>
            <input class="form_page" type="hidden" value="<?php echo esc_attr(get_permalink()); ?>"></input>
            <input type="submit" class="button" value="<?php echo esc_attr(get_field('payment_frame_submit', 'option')); ?>">
        </div>


    </div>
    <div id="alfa-payment-button" data-amount='50000' data-order-number-selector='.orderNumber' data-version='1.0' data-stages='1' data-amount-format='kopeyki' data-client-info-selector='.clientInfo' data-token='fho5sfe6sq4v32c6ao42bacr54'></div>
    <script id="alfa-payment-script" type="text/javascript" src="https://testpay.alfabank.ru/assets/alfa-payment.js">
    </script>
<?php endif; ?>
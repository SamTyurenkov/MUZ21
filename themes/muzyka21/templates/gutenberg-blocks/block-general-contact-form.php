<?php
$post_id = get_query_var('post_id');
$receiver = get_field('receiver');
$translations = get_field('settings', 'option');
?>
<?php wp_nonce_field('_general_contact_form', '_general_contact_form'); ?>
<div class="general-contact-form" id="contact_form">
    <div class="container">
        <div class="general-contact-form_flex">
            <div class="general-contact-form_flex_banner">
                <img class="shape2" src="<?php echo get_template_directory_uri() . '/images/shapes/shape2.svg'; ?>">
                <img src="<?php echo get_template_directory_uri() . '/images/email.svg'; ?>" alt="contact form">
            </div>
            <div class="general-contact-form_flex_text">
                <h2><?php echo get_field('title'); ?></h2>
                <p><?php echo get_field('subtitle'); ?></p>
                <div class="general-contact-form_flex_text_input_holder">
                    <span class="input_container input_large">
                        <label><?php echo esc_html($translations['label_email']); ?></label>
                        <input required type="email" placeholder="your@email.domain" value="<?php echo esc_attr(get_the_author_meta('email', get_current_user_id())); ?>"></input>
                    </span>
                    <span class="input_container input_large">
                        <label><?php echo esc_html($translations['label_display_name']); ?></label>
                        <input class="general-contact-form_username" required type="text" placeholder="Имя или ник" value="<?php echo esc_attr(get_the_author_meta('display_name', get_current_user_id())); ?>"></input>
                    </span>
                    <span class="input_container input_large">
                        <label><?php echo esc_html($translations['label_phone']); ?></label>
                        <input class="general-contact-form_userphone" required type="text" placeholder="+7...." value="<?php echo esc_attr(get_the_author_meta('user_phone', get_current_user_id())); ?>"></input>
                    </span>
                    <input class="general-contact-form_page" type="page" hidden value="<?php echo esc_attr(get_permalink()); ?>"></input>
                    <input type="submit" class="button" value="<?php echo esc_attr(get_field('contact_form_submit_text', 'option')); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
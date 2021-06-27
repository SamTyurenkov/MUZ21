<?php
$post_id = get_query_var('post_id');
$receiver = get_field('receiver');
?>
<div class="general-contact-form" id="contact_form">
    <div class="container">
        <div class="general-contact-form_flex">
            <div class="general-contact-form_flex_banner">
                <img class="shape2" src="<?php echo get_template_directory_uri() . '/images/shapes/shape6.svg'; ?>">
                <img src="<?php echo get_template_directory_uri() . '/images/email.svg'; ?>" alt="contact form">
            </div>
            <div class="general-contact-form_flex_text">
                    <h2><?php echo get_field('title'); ?></h2>
                    <p><?php echo get_field('subtitle'); ?></p>
                    <div class="general-contact-form_flex_text_input_holder">
                    <input required type="email" placeholder="<?php echo esc_attr(get_field('contact_form_email_text','options')); ?>" value="<?php echo esc_attr(get_the_author_meta('email',get_current_user_id())); ?>"></input>
                    <input required type="text" placeholder="<?php echo esc_attr(get_field('contact_form_name_text','options')); ?>" value="<?php echo esc_attr(get_the_author_meta('display_name',get_current_user_id())); ?>"></input>
                    <input required type="text" placeholder="<?php echo esc_attr(get_field('contact_form_phone_text','options')); ?>" value="<?php echo esc_attr(get_the_author_meta('user_phone',get_current_user_id())); ?>"></input>
                    <input type="page" hidden value="<?php echo esc_attr(get_permalink()); ?>"></input>
                    <input type="submit" class="button" value="<?php echo esc_attr(get_field('contact_form_submit_text','options')); ?>" >
                    </div>
            </div>
        </div>
    </div>
</div>
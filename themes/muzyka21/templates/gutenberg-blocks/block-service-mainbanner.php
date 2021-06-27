<?php
$post_id = get_query_var('post_id');
$thumbnail = get_the_post_thumbnail_url($post_id, 'large');
$providers = get_field('providers', $post_id);
$price = get_field('price', $post_id);
?>
<div class="service-mainbanner">
    <div class="container">
        <div class="service-mainbanner_flex">
            <div class="service-mainbanner_flex_left">
                <div class="service-mainbanner_flex_text">
                    <h1><?php echo esc_html(get_the_title($post_id)); ?></h1>
                    <p><?php echo esc_html(get_the_excerpt($post_id)); ?></p>
                </div>
                <div class="service-mainbanner_flex_button">
                    <div class="button scrollto" data-target="#contact_form">
                        <?php echo get_field('button_text'); ?>
                    </div>
                </div>
            </div>
            <div class="service-mainbanner_flex_right">
                <div class="service-mainbanner_flex_image">
                    <img src="<?php echo esc_attr($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>">
                </div>
            </div>

        </div>
    </div>
</div>
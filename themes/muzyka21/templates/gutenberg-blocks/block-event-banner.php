<?php
$post_id = get_query_var('post_id');
$thumbnail = get_the_post_thumbnail_url($post_id, 'large');
$price = get_field('price', $post_id);
$event_place_text = get_field('event_place_text', 'option');
$event_start_text = get_field('event_start_text', 'option');
$event_end_text = get_field('event_end_text', 'option');
?>
<div class="event-banner">
    <img class="shape3" src="<?php echo get_template_directory_uri() . '/images/shapes/shape2.svg'; ?>">
    <div class="container">
        <div class="event-banner_flex">
            <div class="event-banner_flex_left">
                <?php if ($thumbnail) : ?>
                    <img class="event-banner_flex_image" src="<?php echo esc_attr($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>">
                <?php endif; ?>
            </div>
            <div class="event-banner_flex_right">
                <div class="event-banner_flex_text">
                    <h1><?php echo esc_html(get_the_title($post_id)); ?></h1>
                    <p><?php echo esc_html(get_the_excerpt($post_id)); ?></p>
                </div>
                <div class="event-banner_flex_button">
                    <div class="button scrollto" data-target="#price_options">
                        <?php echo get_field('buy_ticket_text', 'option'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="event-banner_flex">
            <div class="event-banner_flex_left">
                <?php if (get_field('place', $post_id)) : ?>
                    <div class="event-banner_flex_place"><b><?= $event_place_text; ?>: </b><?php echo get_field('place',  $post_id)->post_title; ?></div>
                <?php endif; ?>
                <?php if (get_field('date_start',  $post_id)) : ?>
                    <div class="event-banner_flex_start"><b><?= $event_start_text; ?>: </b><?php echo get_field('date_start',  $post_id); ?></div>
                <?php endif; ?>
                <?php if (get_field('date_end',  $post_id)) : ?>
                    <div class="event-banner_flex_end"><b><?= $event_end_text; ?>: </b><?php echo get_field('date_end',  $post_id); ?></div>
                <?php endif; ?>
            </div>
            <div class="event-banner_flex_right">
                <?php if (get_field('place', $post_id)) : ?>
                    <?php $placethumb = get_the_post_thumbnail_url(get_field('place',  $post_id)->ID, 'large'); ?>
                    <img class="event-banner_flex_el_placeimg" srcset="<?php echo esc_attr($placethumb); ?>">

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
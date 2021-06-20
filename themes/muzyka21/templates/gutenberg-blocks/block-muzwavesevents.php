<?php
$event_place_text = get_field('event_place_text');
$event_start_text = get_field('event_start_text');
$event_end_text = get_field('event_end_text');
$posttype = get_post_type(get_the_ID());
?>

<div class="muzwavesevents splide">
<img class="wavesstart" src="<?php echo get_template_directory_uri().'/images/wave3start.svg'; ?>">
<div class="container">
<h2 class="muzwavesevents_title">
<?php echo get_field('title'); ?>
</h2>
<div class="muzwavesevents_description">
<?php echo get_field('description'); ?>
</div>
        <?php
        $args = array(
            'post_type' => 'events',
            'order'     => 'DESC',
            'post_status' => 'publish',
            'orderby'       => 'meta_value',
            'posts_per_page' => 20,
            'meta_query' => array(
                'relation' => 'AND',
                array('key' => 'date_start'
                )
            )
        );

        if($posttype == 'places') {
            $args['meta_query'][] = array(
                'key' => 'place',
                'value' => get_the_ID()
            );
        };
        $query = new WP_Query($args);
        ?>
        <div class="muzwavesevents_flex splide__track">
        <ul class="splide__list">
            <?php
    
            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                    <a class="muzwavesevents_flex_el splide__slide" href="<?php echo esc_attr(get_permalink()); ?>">
                        <?php if(has_post_thumbnail()) : ?>
                        <div class="muzwavesevents_flex_el_icon" style="background-image:url(<?php echo esc_attr(get_the_post_thumbnail_url(null, 'medium')); ?>)">
                        </div>
                        <?php endif; ?>
                        <h3><?php the_title(); ?></h3>
                            
                        <?php if($posttype != 'places' && get_field('place',get_the_ID())) : ?>
                        <div class="muzwavesevents_flex_el_place"><b><?= $event_place_text; ?>: </b><?php echo get_field('place',get_the_ID())->post_title; ?></div>
                        <?php endif; ?>
                        <?php if(get_field('date_start',get_the_ID())) : ?>
                        <div class="muzwavesevents_flex_el_start"><b><?= $event_start_text; ?>: </b><?php echo get_field('date_start',get_the_ID()); ?></div>
                        <?php endif; ?>
                        <?php if(get_field('date_end',get_the_ID())) : ?>
                        <div class="muzwavesevents_flex_el_end"><b><?= $event_end_text; ?>: </b><?php echo get_field('date_end',get_the_ID()); ?></div>
                        <?php endif; ?>
                    </a>
            <?php
            endwhile;
            endif;

            wp_reset_postdata();
            ?>
            </ul>

        </div>
    </div>
    <img class="wavesend" src="<?php echo get_template_directory_uri().'/images/wave2end.svg'; ?>">
</div>
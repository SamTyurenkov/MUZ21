<div class="places-all-extended">
    <div class="container">

        <?php
        $args = array(
            'post_type' => 'services',
            'order'     => 'DESC',
            'post_status' => 'publish',
            'orderby'       => 'modified',
            'posts_per_page' => 20
        );
        $query = new WP_Query($args);
        ?>

        <div class="services-all-extended_flex">
            <?php

            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
            ?>
                    <div class="services-all-extended_flex_el">
                        <a href="<?php echo esc_attr(get_permalink()); ?>" class="services-all-extended_flex_el_icon" style="background-image:url(<?php echo esc_attr(get_the_post_thumbnail_url(null, 'medium')); ?>)">
                            <h3><?php the_title(); ?></h3>
                        </a>

                        <div class="services-all-extended_flex_el_info">
                            <div class="excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="features">
                                <?php
                                $features = get_field('features', get_the_ID());
                                foreach ($features as $feature) { ?>
                                    <div class="feature">
                                        <img src="<?php echo esc_attr(get_template_directory_uri()); ?>/images/shape_logo.svg"><span><?php echo esc_html($feature); ?></span>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>
                    </div>
            <?php
                endwhile;
            endif;
            wp_reset_query();
            wp_reset_postdata();
            ?>

        </div>
    </div>
</div>
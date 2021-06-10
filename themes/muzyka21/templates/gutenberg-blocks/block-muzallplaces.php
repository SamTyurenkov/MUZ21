<div class="muzallplaces">
    <div class="container">

        <?php

        $args = array(
            'post_type' => 'places',
            'order'     => 'DESC',
            'post_status' => 'publish',
            'orderby'       => 'modified',
            'posts_per_page' => 20
        );
        $query = new WP_Query($args);
        ?>
        <div class="muzallplaces_flex">
            <?php
            $colors = ['#ffb2b2','#f0f6bb','#bbf2f6','#c5bbf6','#d1f6bb','#f6e7bb'];
            $i = 0;
            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
            if ($i == 5) $i = 0; ?>
                    <a class="muzallplaces_flex_el" href="<?php echo esc_attr(get_permalink()); ?>">
                        <div class="muzallplaces_flex_el_icon" style="background-image:url(<?php echo esc_attr(get_the_post_thumbnail_url(null, 'medium')); ?>)">
                        <h3 style="background:<?php echo esc_attr($colors[$i]); ?>"><?php the_title(); ?></h3>
                        </div>
                    </a>
            <?php $i++;
            endwhile;
            endif;

            wp_reset_postdata();
            ?>

        </div>
    </div>
</div>
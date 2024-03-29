<div class="places-all-extended">
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
        <div class="places-all-extended_flex">
            <?php
            $colors = ['#ffb2b2', '#f0f6bb', '#bbf2f6', '#c5bbf6', '#d1f6bb', '#f6e7bb'];
            $i = 0;
            if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                    if ($i == 5) $i = 0; ?>
                    <div class="places-all-extended_flex_el">
                        <a href="<?php echo esc_attr(get_permalink()); ?>" class="places-all-extended_flex_el_icon">
                            <img src="<?php echo esc_attr(get_the_post_thumbnail_url(null, 'medium')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                            <h3 style="background:<?php echo esc_attr($colors[$i]); ?>"><?php the_title(); ?></h3>
                        </a>

                        <div class="places-all-extended_flex_el_info">
                            <div class="excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="socials">
                                <?php
                                $socials = get_field('socials', get_the_ID());
                                foreach ($socials as $key => $link) {
                                    if ($link) : ?>
                                        <a href="<?php echo esc_attr($link); ?>" target="_blank">
                                            <img src="<?php echo esc_attr(get_template_directory_uri()); ?>/images/socials/<?php echo esc_attr($key); ?>.svg">
                                        </a>
                                <?php endif;
                                }
                                ?>

                            </div>
                        </div>
                    </div>
            <?php $i++;
                endwhile;
            endif;

            wp_reset_postdata();
            ?>

        </div>
    </div>
</div>
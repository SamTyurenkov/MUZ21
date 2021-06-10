<div class="muzfeatures" style="background-image:url(wp-content/themes/muzyka21/images/waveend.svg)">
    <div class="container">
        <div class="muzfeatures_flex">
            <?php if (have_rows('features')) : while (have_rows('features')) : the_row(); ?>

            <?php $icon = get_sub_field('icon'); ?>
                    <div class="muzfeatures_flex_el">
                        <div class="muzfeatures_flex_el_icon" style="background-image:url(<?php echo esc_attr($icon['url']); ?>)"> </div>
                        <h3><?php the_sub_field('title'); ?></h3>
                        <p><?php the_sub_field('subtitle'); ?></p>
                    </div>
            <?php endwhile;
            endif; ?>

        </div>
    </div>
</div>
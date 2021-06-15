<div class="muzfeatures">
    <div class="container">
        <div class="muzfeatures_flex">
            <?php if (have_rows('features')) : while (have_rows('features')) : the_row(); ?>

            <?php $icon = get_sub_field('icon'); ?>
                    <div class="muzfeatures_flex_el">
                        <?php if($icon) : ?>
                        <div class="muzfeatures_flex_el_icon" style="background-image:url(<?php echo esc_attr($icon['url']); ?>)"> </div>
                        <?php endif; ?>
                        <h3><?php the_sub_field('title'); ?></h3>
                        <p><?php the_sub_field('subtitle'); ?></p>
                    </div>
            <?php endwhile;
            endif; ?>

        </div>
    </div>
    <img class="wavesend" src="<?php echo get_template_directory_uri().'/images/waveend.svg'; ?>">
</div>
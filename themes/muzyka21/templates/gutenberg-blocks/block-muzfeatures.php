<?php
$post_id = get_query_var('post_id');
$option = get_field('option');
$startwave = get_field('startwave');
$posttype = get_post_type($post_id);
?>
<div class="muzfeatures">
<?php if ($startwave == 'show') { ?>
    <img class="wavestart" src="<?php echo get_template_directory_uri() . '/images/wave2start.svg'; ?>">
<?php }; ?>
    <div class="container">
        <div class="muzfeatures_flex">
            <?php if ($option == 'general') { ?>
                <?php if (have_rows('features')) : while (have_rows('features')) : the_row(); ?>

                        <?php $icon = get_sub_field('icon'); ?>
                        <div class="muzfeatures_flex_el">
                            <?php if ($icon) : ?>
                                <div class="muzfeatures_flex_el_icon" style="background-image:url(<?php echo esc_attr($icon['url']); ?>)"> </div>
                            <?php endif; ?>
                            <h3><?php the_sub_field('title'); ?></h3>
                            <p><?php the_sub_field('subtitle'); ?></p>
                        </div>
                <?php endwhile;
                endif; ?>
            <?php } else if ($option == 'services') { ?>
                <?php if (have_rows('main_features',$post_id)) : while (have_rows('main_features',$post_id)) : the_row(); ?>
                        <div class="muzfeatures_flex_el">
                            <h3><?php the_sub_field('title'); ?></h3>
                            <p><?php the_sub_field('subtitle'); ?></p>
                        </div>
                <?php endwhile;
                endif; ?>
            <?php }; ?>
        </div>
    </div>
    <img class="wavesend" src="<?php echo get_template_directory_uri() . '/images/waveend.svg'; ?>">
</div>
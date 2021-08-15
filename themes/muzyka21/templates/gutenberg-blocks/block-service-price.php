<?php
$post_id = get_query_var('post_id');
?>
<div class="service-price">
    <div class="container">
        <div class="service-price_flex">
            <div class="service-price_flex_left">
                <div class="service-price_flex_text">
                    <h2><?php echo esc_html(get_field('title')); ?></h2>
                    <p><?php echo esc_html(get_field('subtitle')); ?></p>
                </div>
                <div class="service-price_flex_price splide__track">
                    <ul class="splide__list">
                        <?php
                        $i = 0;

                        if (have_rows('prices', $post_id)) : while (have_rows('prices', $post_id)) : the_row();
                                if (get_sub_field('option_variant') == 'fix-price') {
                                    $price = (int) get_sub_field('option_price');
                                } else {
                                    $price = get_field('by_request', 'option');
                                }

                        ?>
                                <div class="service-price_flex_price_option splide__slide" data-id=<?php echo esc_attr($i++); ?>>
                                    <h4><?php the_sub_field('option_name'); ?></h4>
                                    <p><?php the_sub_field('option_description'); ?></p>
                                    <?php if (is_numeric($price)) : ?>
                                        <div class="service-price_flex_price_value button"><span><?php echo esc_html($price); ?></span><span>&#8381;</span></div>
                                    <?php else : ?>
                                        <div class="service-price_flex_price_value button"><span><?php echo esc_html($price); ?></span></div>
                                    <?php endif; ?>
                                </div>
                        <?php endwhile;
                        endif; ?>
                    </ul>
                </div>
            </div>

            <div class="service-price_flex_right">
                <div class="service-price_flex_image">
                    <img src="<?php echo esc_attr(get_template_directory_uri() . '/images/wallet.svg'); ?>" alt="<?php echo esc_attr(get_field('title',$post_id)); ?>">
                </div>
            </div>

        </div>
    </div>
</div>
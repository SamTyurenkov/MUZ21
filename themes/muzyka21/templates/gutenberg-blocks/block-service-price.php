<?php
$post_id = get_query_var('post_id');
$price = get_field('price', $post_id);
?>
<div class="service-price">
    <div class="container">
        <div class="service-price_flex">
            <div class="service-price_flex_left">
                <div class="service-price_flex_text">
                    <h2><?php echo esc_html(get_field('title')); ?></h2>
                    <p><?php echo esc_html(get_field('subtitle')); ?></p>
                </div>
                <?php if ($price && $price != '') : ?>
                    <div class="service-price_flex_price">
                            <?php echo esc_html($price); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="service-price_flex_right">
                <div class="service-price_flex_image">
                    <img src="<?php echo get_template_directory_uri() . '/images/wallet.svg'; ?>" alt="<?php echo esc_attr(get_field('title')); ?>">
                </div>
            </div>

        </div>
    </div>
</div>
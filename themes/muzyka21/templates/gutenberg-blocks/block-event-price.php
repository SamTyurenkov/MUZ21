<?php
$post_id = get_query_var('post_id');
$free = get_field('price_free', 'option');
?>
<div class="event-price">
    <div class="container">
        <div class="event-price_flex">
            <div class="event-price_flex_left splide">
                <div class="event-price_flex_text" id="price_options">
                    <h2><?php echo esc_html(get_field('title')); ?></h2>
                    <p><?php echo esc_html(get_field('subtitle')); ?></p>
                </div>
                <div class="event-price_flex_price splide__track">
                    <ul class="splide__list">
                        <?php
                        $i = 0;
                        if (get_field('date_start', get_the_ID())) {
                            $datestart = new DateTime(get_field('date_start', get_the_ID()));
                        };
                        if (get_field('date_end', get_the_ID())) {
                            $dateend = new DateTime(get_field('date_end', get_the_ID()));
                        };

                        if (isset($datestart) && isset($dateend) && time() > $dateend->getTimestamp()) { ?>
                            <div class="event-price_flex_price_option splide__slide">
                                <h4>Событие завершено</h4>
                                <p>Это событие уже закончилось и билеты не продаются</p>
                            </div>
                        <?php  } else if (isset($datestart) && (time() + (60 * 60 * 5)) > $datestart->getTimestamp()) { ?>
                            <div class="event-price_flex_price_option splide__slide">
                                <h4>Событие завершено</h4>
                                <p>Это событие уже закончилось и билеты не продаются</p>
                            </div>
                        <?php } else if (have_rows('prices', $post_id)) {
                            while (have_rows('prices', $post_id)) : the_row();
                                $price = (int) get_sub_field('option_price');

                            ?>
                                <div class="event-price_flex_price_option splide__slide" data-id=<?php echo esc_attr($i++); ?>>
                                    <h4><?php the_sub_field('option_name'); ?></h4>
                                    <p><?php the_sub_field('option_description'); ?></p>
                                    <?php if ($price > 0) : ?>
                                        <div class="event-price_flex_price_value button"><span><?php echo esc_html($price); ?></span><span>&#8381;</span></div>
                                    <?php else : ?>
                                        <div class="event-price_flex_price_value button"><span><?php echo esc_html($free); ?></span></div>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile;
                        } else if (current_user_can('administrator') || current_user_can('edit_post', $post_id)) { ?>
                            <div class="event-price_flex_price_option splide__slide">
                                <h4>Тип билета</h4>
                                <p>Здесь будет описание билета</p>

                                <div class="event-price_flex_price_value button" style="pointer-events:none"><span>XXX </span><span>&#8381;</span></div>
                            </div>
                            <div class="event-price_flex_price_option splide__slide">
                                <h4>Другой тип билета</h4>
                                <p>Здесь будет описание билета</p>

                                <div class="event-price_flex_price_value button" style="pointer-events:none"><span>XXX </span><span>&#8381;</span></div>
                            </div>
                        <?php }; ?>
                    </ul>
                </div>

            </div>
            <div class="event-price_flex_right">
                <div class="event-price_flex_image">
                    <img src="<?php echo get_template_directory_uri() . '/images/wallet.svg'; ?>" alt="<?php echo esc_attr(get_field('title')); ?>">
                </div>
            </div>

        </div>
    </div>
</div>
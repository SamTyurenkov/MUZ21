<div class="audioplayer">
    <div class="container">

        <div class="audioplayer_inner ">
        <span class="button close closestream" style="right: 0;position: absolute;top: 0;padding: 3px 7px;background: #ffffff;padding: 10px;font-size:20px;color: #687780;box-shadow:none;z-index: 99">X</span>
            <div class="audioplayer_title">
                <h3>Стрим</h3>
            </div>
            <audio autoplay muted="true" type="audio/mp3" controls="controls">

            </audio>

            <div class="audioplayer_list splide__track">
                <ul class="splide__list">
                    <?php if (have_rows('channels', 'options')) : while (have_rows('channels', 'options')) : the_row(); ?>

                            <div class="audioplayer_list_el splide__slide" data-src="<?php echo esc_attr(get_sub_field('link')); ?>" style="background:url(<?php echo esc_attr(wp_get_attachment_image_src(get_sub_field('image')['ID'],'medium')[0]); ?>)  no-repeat center center; background-size:cover">
                                <div class="audioplayer_list_el_play"></div>
                                <div class="audioplayer_list_el_title"><?php the_sub_field('title'); ?></div>
                            </div>
                    <?php endwhile;
                    endif; ?>
                </ul>
            </div>
            <!-- <p class="audioplayer_status">
                Сейчас играет
                </p>-->
            <div class="audioplayer_pp">
            </div>

            <div class="audioplayer_volume">
                <input type="range" max="100" value="100">
                <button id="mute-icon"></button>
            </div>
        </div>
    </div>
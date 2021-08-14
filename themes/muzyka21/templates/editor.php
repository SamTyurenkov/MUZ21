<?php if (is_singular('events') && current_user_can('edit_post', get_the_ID())) : ?>
    <?php wp_nonce_field('_editor', '_editor'); ?>
    <div class="editor-frame">

        <div class="editor-frame_buttons">
            <div class="button editor-frame_buttons_edit">Редактировать</div>
            <div class="button editor-frame_buttons_delete">Удалить</div>
            <div class="button editor-frame_buttons_mod">На модерацию</div>
        </div>

        <div class="editor-frame_content">

            <div class="editor-frame_content_part">

                <h4>Информация о событии</h4>

                <span class="input_container input_large">
                    <label>Название</label>
                    <input class="text event_title" type="email" value="<?php echo esc_attr(get_the_title(get_the_ID())); ?>" placeholder="Какой-то Концерт">
                </span>
                <span class="input_container input_large">
                    <label>Описание</label>
                    <textarea spellcheck="true" rows="7" class="text event_description" value="" placeholder="Почему стоит посетить?"><?php echo esc_html(get_the_excerpt(get_the_ID())); ?></textarea>
                </span>

                <span class="input_container input_large">
                    <label>Место проведения</label>
                    <select class="text event_place">

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
                        <?php
                        $place = get_field('place',get_the_ID());
                        if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

                                <option value="<?php echo esc_attr(get_the_ID()); ?>" <?php if($place->ID == get_the_ID()) echo 'selected'; ?> ><?php echo esc_html(get_the_title()); ?></option>

                        <?php
                            endwhile;
                        endif;

                        wp_reset_postdata();
                        ?>
                    </select>
                </span>
            </div>
            <div class="editor-frame_content_part">

                <h4>Изображение события</h4>
                <div class="field eventthumb">

                    <label for="eventthumb" style="<?php if (has_post_thumbnail(get_the_ID())) echo 'background:url(' . esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')) . ');background-size: cover'; ?>"></label>

                    <input type="file" name="eventthumb" id="eventthumb" multiple="false">
                </div>

                <?php
                $datestart = new DateTime(get_field('date_start',get_the_ID()));
                $dateend = new DateTime(get_field('date_end',get_the_ID()));
                ?>
                <h4>Когда будет проходить</h4>
                <span class="input_container input_large">
                    <label>Дата и время начала</label>
                    <input type="datetime-local" class="text event_date_start" value="<?php echo date('Y-m-d\TH:i:s',$datestart->getTimestamp()); ?>">
                </span>

                <span class="input_container input_large">
                    <label>Дата и время конца</label>
                    <input type="datetime-local" class="text event_date_end" value="<?php echo date('Y-m-d\TH:i:s',$dateend->getTimestamp()); ?>">
                </span>
            </div>
            <div class="editor-frame_content_part tickets_editor">

                <h4>Билеты</h4>
                <div class="editor-frame_content_part_tickets">
                    <?php
                    $i = 0;
                    if (have_rows('prices', get_the_ID())) : while (have_rows('prices', get_the_ID())) : the_row(); ?>
                            <div class="editor-frame_content_part_tickets_tab <?php if($i == 0) echo 'active'; ?>" data-id="<?= $i; ?>">
                                <?= $i; ?>
                            </div>
                    <?php $i++;
                        endwhile;
                    else : ?>
                            <div class="editor-frame_content_part_tickets_tab <?php if($i == 0) echo 'active'; ?>" data-id="0">
                                0
                            </div>
                    <?php endif; ?>
                    <div class="editor-frame_content_part_tickets_tab ticket_plus" data-id="+">
                        +
                    </div>
                </div>
                <?php
                $i = 0;
                if (have_rows('prices', get_the_ID())) : while (have_rows('prices', get_the_ID())) : the_row();
                        $price = (int) get_sub_field('option_price') ? get_sub_field('option_price') : '';
                        $name = get_sub_field('option_name') ? get_sub_field('option_name') : '';
                        $desc = get_sub_field('option_description') ? get_sub_field('option_description') : ''; ?>
                        <div class="editor-frame_content_part_ticket <?php if($i == 0) echo 'active'; ?>" data-id="<?= $i; ?>">
                            <span class="input_container">
                                <label>Стоимость</label>
                                <input class="text option_price" type="number" value="<?= $price; ?>" min="0" placeholder="0+">
                            </span>
                            <span class="input_container ticket_delete">
                            <div class="button editor-frame_content_part_ticket_delete">Удалить</div>
                            </span>
                            <span class="input_container input_large">
                                <label>Тип билета</label>
                                <input class="text option_name" type="text" value="<?= $name; ?>" placeholder="Обычный билет">
                            </span>
                            <span class="input_container input_large">
                                <label>Описание билета</label>
                                <textarea spellcheck="true" rows="6" class="text option_description" max="200" placeholder="Что входит в билет?"><?= $desc; ?></textarea>
                            </span>
                        </div>
                <?php $i++;
                    endwhile;
                else :?>
                        <div class="editor-frame_content_part_ticket active" data-id="0">
                            <span class="input_container input_large">
                                <label>Стоимость</label>
                                <input class="text option_price" type="number" value="<?= $price; ?>" min="0" placeholder="0+">
                            </span>
                            <span class="input_container input_large">
                                <label>Тип билета</label>
                                <input class="text option_name" type="text" value="<?= $name; ?>" placeholder="Обычный билет">
                            </span>
                            <span class="input_container input_large">
                                <label>Описание билета</label>
                                <textarea spellcheck="true" rows="6" class="text option_description" max="200" placeholder="Что входит в билет?"><?= $desc; ?></textarea>
                            </span>

                <?php endif; ?>
            </div>
        </div>

    </div>

<?php endif; ?>
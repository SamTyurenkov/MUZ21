<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$curuser = wp_get_current_user();
?>

<div class="usermenu">

    <div class="usermenu_tabs">
        <?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) : ?>
            <div class="usermenu_tabs_el" data-id="1">Заказы</div>
            <div class="usermenu_tabs_el" data-id="2">Настройки</div>
        <?php endif; ?>

    </div>
    <div class="usermenu_tabscontent">
        <?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) : ?>
            <div class="usermenu_tabscontent_el" data-id="1">

                <?php get_template_part('templates/usermenu-parts/orders'); ?>

            </div>
            <div class="usermenu_tabscontent_el" data-id="2">
                
                <?php get_template_part('templates/usermenu-parts/settings'); ?>

            </div>
        <?php endif; ?>

    </div>

</div>
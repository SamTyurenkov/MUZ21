<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$curuser = wp_get_current_user();
$isresident = get_user_meta($curauth->ID, 'resident', true);
$translations = get_field('usermenu','option');
?>

<div class="usermenu">

    <div class="usermenu_tabs">
        <?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) : ?>
            <div class="usermenu_tabs_el" data-name="settings"><?php echo esc_html($translations['settings']); ?></div>
            <div class="usermenu_tabs_el" data-name="orders"><?php echo esc_html($translations['orders']); ?></div>
        <?php endif; ?>
        <?php if ($isresident) { ?>
            <div class="usermenu_tabs_el" data-name="events"><?php echo esc_html($translations['events']); ?></div>
        <?php }; ?>
    </div>
    <div class="usermenu_tabscontent">
        <?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) : ?>
            <div class="usermenu_tabscontent_el" data-name="settings">

                <?php get_template_part('templates/usermenu-parts/settings'); ?>

            </div>
            <div class="usermenu_tabscontent_el" data-name="orders">

                <?php get_template_part('templates/usermenu-parts/orders'); ?>

            </div>
        <?php endif; ?>
        <?php if ($isresident) : ?>
            <div class="usermenu_tabscontent_el" data-name="events">

                <?php get_template_part('templates/usermenu-parts/events'); ?>

            </div>
        <?php endif; ?>


    </div>

</div>
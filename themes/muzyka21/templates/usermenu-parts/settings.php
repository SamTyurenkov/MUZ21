<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$curuser = wp_get_current_user();
$translations = get_field('settings','option');
$name = get_the_author_meta('display_name', $curauth->ID);
$phone = get_the_author_meta('user_phone', $curauth->ID);
?>


<div class="editauthor">

    <h4><?php echo esc_html($translations['settings_header']); ?></h4>

    <span class="input_container input_large">
        <label><?php echo esc_html($translations['label_email']); ?></label>
        <input class="text user_email" type="email" value="<?php echo esc_html(get_the_author_meta('user_email', $curauth->ID)); ?>" placeholder="your@email.domain">
    </span>
    <span class="input_container">
        <label><?php echo esc_html($translations['label_display_name']); ?></label>
        <input class="text display_name" type="text" value="<?php echo esc_html($name); ?>" placeholder="Имя или ник">
    </span>

    <span class="input_container">
        <label><?php echo esc_html($translations['label_phone']); ?></label>
        <input class="text user_phone" type="text" value="<?php echo esc_html($phone); ?>" placeholder="+7....">
    </span>
</div>
<?php
$post_id = get_query_var('post_id');
$thumbnail = get_the_post_thumbnail_url($post_id, 'large');
$providers = get_field('providers', $post_id);
if (get_field('titletype')) {
    $titletype = get_field('titletype');
} else {
    $titletype = 'h1';
}
?>
<div class="muzsidebanner">
    <div class="container">
        <div class="muzsidebanner_flex">
            <div class="muzsidebanner_flex_image">
                <img src="<?php echo esc_attr($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>">
            </div>
            <div class="muzsidebanner_flex_text">
                <<?php echo esc_attr($titletype); ?>><?php echo get_the_title($post_id); ?></<?php echo esc_attr($titletype); ?>>
                <p><?php echo get_the_excerpt($post_id); ?></p>
            </div>
        </div>
    </div>
</div>
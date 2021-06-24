<?php
$post_id = get_query_var('post_id');
$thumbnail = get_the_post_thumbnail_url($post_id, 'large');
$providers = get_field('providers', $post_id);
?>
<div class="muzsidebanner">
<div class="container">
<div class="muzsidebanner_flex">
<div class="muzsidebanner_flex_image">
<img src="<?php echo esc_attr($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>">
</div>
<div class="muzsidebanner_flex_text" >
<h2><?php echo get_the_title($post_id); ?></h2>
<p><?php echo get_the_excerpt($post_id); ?></p>
</div>
</div>
</div>
</div>
<?php
$banner = get_field('banner');
?>
<div class="muzsidebanner">
<div class="container">
<div class="muzsidebanner_flex">
<div class="muzsidebanner_flex_image">
<img src="<?php echo esc_attr($banner['url']); ?>" alt="<?php echo esc_attr($banner['alt']); ?>">
</div>
<div class="muzsidebanner_flex_text" >
<h2><?php the_field('title'); ?></h2>
<p><?php the_field('subtitle'); ?></p>
</div>
</div>
</div>
</div>
<?php
$banner = get_field('banner');
?>
<div class="muzbanner" style="background-image:url(<?php echo esc_attr($banner['url']); ?>);">
<div class="ocean">
  <div class="wave"></div>
  <div class="wave"></div>
</div>
<div class="container">
<div class="muzbanner_text" >
<h2><?php the_field('title'); ?></h2>
<p><?php the_field('subtitle'); ?></p>
</div>
</div>
</div>
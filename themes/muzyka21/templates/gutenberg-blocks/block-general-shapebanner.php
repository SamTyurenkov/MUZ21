<?php 
$titletype = get_field('title_type'); 
$image = get_field('image');
?>
<div class="general-shapebanner">
        
        <img class="shape" src="<?php echo get_template_directory_uri() . '/images/shapes/shape2.svg'; ?>">
        <img class="image" src="<?php echo esc_attr($image['url']); ?>">
        <div class="container">
            <div class="general-shapebanner_text">
                <<?php echo esc_attr($titletype); ?>><?php the_field('title'); ?></<?php echo esc_attr($titletype); ?>>
                <p><?php the_field('subtitle'); ?></p>
            </div>
        </div>
        <img class="shape2" src="<?php echo get_template_directory_uri() . '/images/shapes/shape4.svg'; ?>">
</div>

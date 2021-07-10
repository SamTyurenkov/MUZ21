<?php
$post_id = get_query_var('post_id');
$gallery = get_field('gallery', $post_id);
?>
<div class="general-gallery">
    <div class="container">
        <h2 class="general-gallery_title">
            <?php echo get_field('title'); ?>
        </h2>
        <p class="general-gallery_description">
            <?php echo get_field('subtitle'); ?>
        </p>
        <div class="general-gallery_flex">
            <?php
            foreach ($gallery as $item) : ?>
                <figure class="general-gallery_flex_el">
                    <img src="<?php echo esc_attr($item['url']); ?>" alt="<?php echo esc_attr($item['url']); ?>">
                    <figcaption><?php echo esc_attr($item['caption']); ?></figcaption>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</div>
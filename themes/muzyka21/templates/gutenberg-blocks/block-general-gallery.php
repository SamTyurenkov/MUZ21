<?php
$post_id = get_query_var('post_id');
$gallery = get_field('gallery', $post_id);
?>
<div class="general-gallery">
    <div class="container">
    <div class="general-gallery_flex">
        <?php
       $i = 0;
        foreach ($gallery as $item) : ?>
             <figure class="general-gallery_flex_el <?= $i == 0 ? 'active' : ''; ?>">
                <img src="<?php echo esc_attr($item['url']); ?>" alt="<?php echo esc_attr($item['url']); ?>">
                <figcaption><?php echo esc_attr($item['caption']); ?></figcaption>
            </figure>
        <?php $i++; endforeach; ?>
        </div>
    </div>
</div>
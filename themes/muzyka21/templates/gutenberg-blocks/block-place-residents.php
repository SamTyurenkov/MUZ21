<?php
$post_id = get_query_var('post_id');
$residents = get_field('residents', $post_id);
//print_r($residents);

?>
<div class="place-residents">
    <div class="container">
        <h2><?php echo get_field('title'); ?></h2>
        <p><?php echo get_field('subtitle'); ?></p>
        <div class="place-residents_flex">
            <?php foreach ($residents as $res) : ?>
                <a class="place-residents_flex_resident" href="/author/<?php echo esc_attr($res['nickname']); ?>">
                    <div class="place-residents_flex_resident_img"><?php echo $res['user_avatar']; ?></div>
                    <div class="place-residents_flex_resident_name"><?php echo $res['display_name']; ?></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
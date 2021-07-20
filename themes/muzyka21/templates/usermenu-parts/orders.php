<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$curuser = wp_get_current_user();

$args = array(
    'post_type' => 'purchases',
    'order'     => 'DESC',
    'post_status' => 'publish',
    'orderby'       => 'modified',
    'posts_per_page' => 20
);

$args['meta_query'][] = array(
        'key' => 'user_email',
        'value' => $curauth->user_email
);

$loop = new WP_Query($args);

if($loop->have_posts()) : while($loop->have_posts()) : $loop->the_post(); ?>



<div class="order">
    <h3><?php get_the_title(); ?></h3>
    <div class="order_price"><?php echo get_field($price); ?></div>
    <div class="order_status"><?php echo get_field($status); ?></div>
    <a class="button" href="<?php echo esc_attr(get_permalink(get_field($place_id))); ?>">Посмотреть событие</a>
</div>

<?php endwhile; endif; ?>
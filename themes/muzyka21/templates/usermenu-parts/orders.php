<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$curuser = wp_get_current_user();
$translations = get_field('orders','option');
$statuses = get_field('order_statuses','option');
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

$loop = new WP_Query($args);?>
<div class="orders">
<?php
if($loop->have_posts()) : while($loop->have_posts()) : $loop->the_post(); ?>

<div class="order">
    <h4><?php get_the_title(); ?></h4>
    <div class="order_price"><?php echo esc_html(get_field('price')); ?></div>
    <div class="order_status"><?php echo esc_html($statuses[get_field('status')]); ?></div>
    <a class="button" href="<?php echo esc_attr(get_permalink(get_field($place_id))); ?>"><?php echo esc_html($translations['view_event']); ?></a>
</div>

<?php endwhile; else : ?>

<div class="order">
    <h4><?php echo esc_html($translations['no_orders_title']); ?></h4>
    <p><?php echo esc_html($translations['no_orders_description']); ?></p>
</div>

    
<?php endif; wp_reset_postdata();  ?>
</div>
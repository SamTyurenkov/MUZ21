<?php
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$curuser = wp_get_current_user();
$translations = get_field('events','option');
$post_statuses = get_field('post_statuses','option');
$pendargs = array('post_type' => 'events', 'post_status' => 'pending', 'author' => $curauth->ID, 'posts_per_page' => 4);
$pendqu = new WP_Query($pendargs);
$count = $pendqu->post_count;
wp_reset_postdata();
?>
<?php if ($count > 2) { ?>
	<div class="author_event">
	<?php echo esc_html($translations['too_many_drafts']); ?>
	</div>
<?php } else if ($count < 3) { ?>
	<div class="author_event">
		<h4><?php echo esc_html($translations['add_event_header']); ?></h4>
		<span class="input_container">
			<label><?php echo esc_html($translations['add_event_label']); ?></label>
			<input class="neweventname" type="text" placeholder="Какой-нибудь концерт" autocomplete="off" />
		</span>
		<div class="button createevent"><?php echo esc_html($translations['add_event_button']); ?></div>
	</div>
	<?php };
//QUERY ALL AUTHORS EVENTS
$args = array(
	'post_type' => 'events',
	'order'     => 'DESC',
	'post_status' => 'publish',
	'orderby'       => 'meta_value',
	'posts_per_page' => 20,
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => 'date_start'
		)
	)
);

if (current_user_can('administrator') && $curauth->ID == $curuser->ID) {
	$args['post_status'] = 'all';
} else if (current_user_can('administrator') || $curauth->ID == $curuser->ID) {
	$args['post_status'] = 'all';
	$args['post_author'] = $curauth->ID;
};


$query = new WP_Query($args);

if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

		<a class="author_event" href="<?php echo esc_attr(get_the_permalink()); ?>">

				<div class="author_event_thumb" style="background-image:url(<?php echo esc_attr(get_the_post_thumbnail_url(null, 'medium')); ?>)"></div>

			<div class="author_event_right">
				<div class="author_event_date"><?php echo get_field('date_start',  $post_id); ?></div>
				<?php if (current_user_can('administrator') && $curauth->ID == $curuser->ID) { ?>
					<div class="author_event_status"><?php echo esc_html($post_statuses[get_post_status()]); ?></div>
				<?php }; ?>
				<div class="author_event_title"><?php the_title(); ?></div>
			</div>
		</a>

<?php endwhile;
endif;
wp_reset_postdata();
?>
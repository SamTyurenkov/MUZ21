<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
};
global $curauth;
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$curuser = wp_get_current_user();
$uid = $curuser->ID; 

get_header();



$name = get_the_author_meta('display_name', $curauth->ID);
$phone = get_the_author_meta('user_phone', $curauth->ID);
$avaversion = get_the_author_meta( 'avaversion', $curauth->ID);

wp_localize_script('muzyka21-author_page', 'localize_author', array(
	'aid' => $curauth->ID,
));
?>
<div>
	<div class="container">
		<div class="author_page">
			<div class="small-container">
				<div class="author_shape">
				
				</div>
				<?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) { ?>
					<div id="logout" class="button">Выйти</div>
					<?php wp_nonce_field('_editauthmeta', '_editauthmeta'); ?>
				<?php }; ?>
				<div class="field user_thumb">

					<label for="userthumb" style="<?php echo 'background:url(' . esc_url(get_avatar_url($curauth->ID, array('size' => 150,)).'?v='.$avaversion) . ');background-size: cover'; ?>">Аватар</label>
					<?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) { ?>
						<input type="file" name="userthumb" id="userthumb" multiple="false">
					<?php }; ?>
				</div>
				<?php if (have_posts() == false || $curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) { ?>
					<div class="editauthor"> 
						<span class="input_container">
						<label>Отображаемое имя</label>
						<input class="text display_name" type="text" value="<?php echo esc_html($name); ?>" placeholder="Имя или ник">
						</span>
						<span class="input_container">
						<label>E-mail адрес</label>
						<input class="text user_email" type="email" value="<?php echo esc_html(get_the_author_meta('user_email', $curauth->ID)); ?>" placeholder="your@email.domain">
						</span>
						<span class="input_container">
						<label>Контактный телефон</label>
						<input class="text user_phone" type="text" value="<?php echo esc_html($phone); ?>" placeholder="+7....">
						</span>
					</div>
				<?php } else { ?>
					<h1><?php echo esc_html($name); ?></h1>
				<?php }?>
			</div>
			<div class="medium-container">
				<?php
				if (get_user_meta($uid, 'valimail', true) == false) {
					get_template_part('templates/emailvalidation');
				} else {
					get_template_part('templates/usermenu');
				}
				?>
			</div>
		</div>


	</div>
</div>

<?php get_template_part('templates/authquery'); ?>

<?php get_footer(); ?>
</body>

</html>
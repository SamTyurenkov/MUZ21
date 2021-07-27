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
$avaversion = get_the_author_meta('avaversion', $curauth->ID);

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

					<label for="userthumb" style="<?php echo 'background:url(' . esc_url(get_avatar_url($curauth->ID, array('size' => 150,)) . '?v=' . $avaversion) . ');background-size: cover'; ?>">Аватар</label>
					<?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) { ?>
						<input type="file" name="userthumb" id="userthumb" multiple="false">
					<?php }; ?>
				</div>
					<h1><?php echo esc_html($name); ?></h1>
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

		<?php if ((current_user_can('administrator'))) { ?>
			<div class="adminmenu">
				<h2> Admin Menu </h2>
				<div class="button validateuseremail">Validate User Email</div>
				<div class="button invalidateuseremail">InValidate User Email</div>
				<div class="button makeresident">Make Resident</div>
				<div class="button cancelresident">Cancel Resident</div>
			</div>
		<?php }; ?>
	</div>
</div>


<?php get_footer(); ?>
</body>

</html>
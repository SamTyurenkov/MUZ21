<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
?>
<?php get_template_part('templates/editor'); ?>
<?php get_template_part('templates/payments'); ?>

<footer class="footer">
	<div class="container">
		<?php
		wp_nav_menu(array(
			'menu' => 'footer'
		));
		?>
	</div>
</footer>
<?php
get_template_part('templates/audioplayer');
?>
<div class="errors">

</div>
<?php
wp_footer();
?>
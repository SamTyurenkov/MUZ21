<?php /* Template Name: ADMINKA */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}; 
global $post;
get_header();
?>
<div class="container stickymenu">
<?php get_template_part('templates/topmenu'); ?>

</div>

<div class="empty"></div>
<?php if(current_user_can('editor' || 'administrator')) get_template_part('templates/adminkaquery'); ?>

<?php get_footer(); ?>
</body>
</html>
<?php /* Template Name: RESET PASS */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}; 
global $post;
get_header();
?>
<div class="container">
<?php echo do_shortcode('[custom-password-reset-form]'); ?>


</div>

<?php get_footer(); ?>
</body>
</html>
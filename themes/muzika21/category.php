<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}; 
get_header();
?>
<div class="container stickymenu transparentmenu">
<?php get_template_part('templates/topmenu'); ?>
</div>

<div class="empty"></div>
<?php get_template_part('templates/blogquery'); ?>


<div style="text-align:center;padding-bottom:20px">
<?php get_template_part('templates/sharer'); ?>
</div>

<?php get_footer(); ?>
</body>
</html>
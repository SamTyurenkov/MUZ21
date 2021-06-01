<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}; 
get_header();
?>
<div class="container stickymenu transparentmenu" style="height:60px;">
<?php get_template_part('templates/topmenu'); ?>
</div>
<div class="bannercontrols"> 
<?php get_template_part('templates/homecats'); ?>
</div>
<div class="banner" style="position:relative;top:-60px;margin-bottom:-60px">

</div>

<?php 

get_template_part('templates/homequery'); ?>

<?php
get_footer();
?>
</body>
</html>
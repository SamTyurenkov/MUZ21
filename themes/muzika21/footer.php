<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="footer">
<div class="container">
	
<div class="footer_col">
<h3>© ASP Недвижимость</h3>
<?php wp_nav_menu( array(
'menu' => 'terms'
) ); ?>
</div>

<div class="footer_col">
<h3>Решения для бизнеса</h3>	
<?php wp_nav_menu( array(
'menu' => 'business'
) ); ?>
</div>

</div>
</div>
<script>
var menu = document.querySelector('.stickymenu');
window.onscroll = function() {transparentMenu()};

function transparentMenu() {
  if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
    menu.classList.remove('transparentmenu');
  } else {
    menu.classList.add('transparentmenu');
  }
}
</script>
<?php if (!is_user_logged_in()) { ?> 
<script type="text/javascript">
function loadauth(n,m = '') {
if (n==1) {
	document.querySelector('.acca').classList.add('expanded');
} else {
	document.querySelector('.acca').classList.remove('expanded');
}
}
function openaddproperty() {
	document.querySelector('.acca').classList.add('expanded');
}
</script>
<?php } else { 
$curuser = get_current_user_id();
?>
<script type="text/javascript">
function loadauth(n,m = '') {
var url = '<?php echo esc_attr(get_author_posts_url( $curuser )); ?>';
	closeaddproperty();
	if(window.history.pushState) {
    window.history.pushState('', '/', window.location.pathname)
	} else {
    window.location.hash = '';
	}
	if(window.location.href == url) {
	window.location.href += m;
	location.reload();
	return false;
	} else {
	window.location.href = url+m
	return false;
	}
}
function closeaddproperty() {
	document.querySelector('.addproperty').classList.remove('expanded');
}
function openaddproperty() {
	document.querySelector('.addproperty').classList.add('expanded');
}
</script>
<div class="container errors">

</div>
<?php };
wp_footer();
 ?>
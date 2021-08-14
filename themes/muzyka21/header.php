<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$uid = wp_get_current_user()->ID;
?>
<!DOCTYPE html>
<html lang="ru" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta id="myViewport" name="viewport" content="width=device-width, initial-scale=1.0">
	<script>
		if (screen.width > 1980) {
			var mvp = document.getElementById('myViewport');
			mvp.setAttribute('content', 'width=1980, initial-scale=1.0');
		};
	</script>
	<title><?php
	if(is_singular()) {
	 the_title();
	} else if (is_author()) {
		$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
		$name = get_the_author_meta('display_name', $curauth->ID);
		echo esc_html($name);	
	}
	 ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#d03030">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#d03030">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#d03030">

	<?php wp_head(); ?>
	<?php $my_home_url = apply_filters('wpml_home_url', get_option('home')); ?>
</head>

<body>
	<header>
		<div class="container">
			<div class="topbar">
				<div class="topbar_left">

					<a href="<?php echo esc_attr($my_home_url); ?>">
						<div class="logo_shape"></div><span>MUSIC XXI</span>
					</a>
				</div>
				<div class="topbar_center">
					<?php
					wp_nav_menu(array(
						'menu' => 'topbar',
						'walker' => new Core\TopWalker()
					));
					?>
				</div>
				<div class="topbar_right">
					<?php
					wp_nav_menu(array(
						'menu' => 'personal'
					));
					?>
				</div>
				<div class="topbar_mobile">
					<div class="menu_button"></div>
				</div>
			</div>

		</div>
		<div class="menu_mobile_container">
			<div class="menu_mobile">
				<div class="menu_button">X</div>
				<?php
				wp_nav_menu(array(
					'menu' => 'topbar',
				));
				?>
				<?php
				wp_nav_menu(array(
					'menu' => 'personal',
					'container_class' => 'menu-personal'
				));
				?>
			</div>
		</div>
	</header>

	<!-- LOGIN/REGISTRATION -->
	<?php
	if (!is_user_logged_in()) {
		get_template_part('templates/loginregistration');
	} ?>
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
	<title><?php the_title(); ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Chrome, Firefox OS and Opera -->
	<meta name="theme-color" content="#d03030">
	<!-- Windows Phone -->
	<meta name="msapplication-navbutton-color" content="#d03030">
	<!-- iOS Safari -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#d03030">

	<?php wp_head(); ?>
	<?php $my_home_url = apply_filters( 'wpml_home_url', get_option( 'home' ) ); ?>
</head>

<body>
	<header>
		<div class="container">
			<div class="topbar">
				<div class="topbar_left">
					<div class="logo_shape"></div>
					<a href="<?php echo esc_attr($my_home_url); ?>">MUZYKA<br>XXI</a>
				</div>
				<div class="topbar_center">
					<?php
					wp_nav_menu(array(
						'menu' => 'topbar'
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
		<div class="menu_mobile">
			<div class="menu_button">X</div>
			<?php
			wp_nav_menu(array(
				'menu' => 'mobile'
			));
			?>
		</div>
	</header>

	<!-- LOGIN/REGISTRATION -->
	<?php
	if (!is_user_logged_in()) {
		get_template_part('templates/loginregistration');
	} ?>
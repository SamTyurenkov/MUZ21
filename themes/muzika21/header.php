<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
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
</head>

<body>
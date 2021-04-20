<?php
if ( ! defined( 'ABSPATH' ) ) {
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
    mvp.setAttribute('content','width=1980, initial-scale=1.0');
};	
</script>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="twitter:card" content="summary_large_image" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="ASP">
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="315">

<?php if ( is_404() ) {
    http_response_code(404);
	status_header( 404 ); ?>
<meta name="robots" content="noindex,nofollow">
<?php };
		if (is_author()) {?>
  <title><?php
  $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
  $dname = get_the_author_meta( 'display_name', $curauth->ID );
  echo get_the_author_meta( 'display_name', $curauth->ID ).' | '; esc_html_e( 'ASP Недвижимость', 'pbg' ); ?></title>
  <meta name="twitter:title" content="<?php echo esc_attr($dname).' | '; esc_attr_e(  'ASP Недвижимость', 'pbg' ); ?>">
  <meta property="og:title" content="<?php echo esc_attr($dname).' | '; esc_attr_e(  'ASP Недвижимость', 'pbg' ); ?>">
  <meta name="description" content="<?php esc_attr_e( 'Объявления, блог и новости от пользователя: ', 'pbg' ); echo esc_attr($dname); ?>." />
  <meta name="twitter:description" content="<?php esc_attr_e( 'Объявления, блог и новости от пользователя: ', 'pbg' ); echo ' '.esc_attr($dname); ?>." />
  <meta property="og:description" content="<?php esc_attr_e( 'Объявления, блог и новости от пользователя: ', 'pbg' ); echo ' '.esc_attr($dname); ?>.">
  <meta name="robots" content="index">
  <?php };
  if (is_home()) { ?>
      <title>Недвижимость и туризм | ASP Недвижимость</title>
	  	<meta name="twitter:title" content="Недвижимость и туризм | ASP Недвижимость">
	   <meta property="og:title" content="Недвижимость и туризм | ASP Недвижимость">
	  <meta name="description" content="ASP Недвижимость | Объявления о покупке, продаже, аренде квартир, домов, и коммерческой недвижимости. Вторичное жилье и новостройки. Офисы и торговые помещения. Цены на недвижимость. Бесплатные объявления о недвижимости." /> 
	    <meta name="twitter:description" content="ASP Недвижимость | Объявления о покупке, продаже, аренде квартир, домов, и коммерческой недвижимости. Вторичное жилье и новостройки. Офисы и торговые помещения. Цены на недвижимость. Бесплатные объявления о недвижимости." />
	  <meta name="keywords" content="ASP Недвижимость | Объявления о покупке, продаже, аренде квартир, домов, и коммерческой недвижимости. Вторичное жилье и новостройки. Офисы и торговые помещения. Цены на недвижимость. Бесплатные объявления о недвижимости." />
	<meta property="og:description" content="ASP Недвижимость | Объявления о покупке, продаже, аренде квартир, домов, и коммерческой недвижимости. Вторичное жилье и новостройки. Офисы и торговые помещения. Цены на недвижимость. Бесплатные объявления о недвижимости.">
	<meta property="og:url" content="https://asp.sale">	  
	<link rel="canonical" href="https://asp.sale" />
  <?php } elseif (is_tax('property-type')) {
$taxonomy = get_queried_object();
$singletitle = single_term_title('',false);
$city = get_query_var( 'city' );
$ptype = get_query_var( 'ptype' );	
$dtype = get_query_var( 'dtype' );	
$title = '';
if (!empty($city)) {
if(array_key_exists($city,CityManager::getCities())) {
	$city = CityManager::getCityBySlug($city);
	$title = $city.' - ';
} else {
	echo '<meta name="robots" content="noindex">';
}
}
$title .= $singletitle.' ';

if (!empty($ptype)) {
	
switch($ptype) {
case 'kvartira':
	$typetitle = 'Квартиру';
	break;
case 'dom':
	$typetitle = 'Дом';
	break;
case 'komnata':
	$typetitle = 'Комнату';
	break;
case 'koikomesto':
	$typetitle = 'Койко-место';
	if($singletitle == 'Купить') {	
	echo '<meta name="robots" content="noindex">';
	}
	break;
case 'nezhiloe':
	$typetitle = 'Нежилое Помещение';
	if($singletitle == 'Посуточно Снять') {	
	echo '<meta name="robots" content="noindex">';
	}
	break;
case 'uchastok':
	$typetitle = 'Участок';
	if($singletitle == 'Посуточно Снять') {	
	echo '<meta name="robots" content="noindex">';
	}
	break;
case 'hotel':
	$typetitle = 'Номер в Отеле';
	if($singletitle == 'Купить') {	
	echo '<meta name="robots" content="noindex">';
	}
	break;
case 'novostrojka':
	$typetitle = 'Квартиру в Новостройке';
	if($singletitle == 'Посуточно Снять') {	
	echo '<meta name="robots" content="noindex">';
	}
	break;
case 'nedvizhimost':
	$typetitle = 'Недвижимость';
	if(empty($city)) {	
	echo '<meta name="robots" content="noindex">';
	}
	break;		
default:
	$typetitle = 'Недвижимость';
	if(empty($city)) {	
	echo '<meta name="robots" content="noindex">';
	}
	break;
}
	
$title .= $typetitle;
} else {
$title .= 'Недвижимость';	
}
	 ?>
  <title><?php echo esc_html($title); ?></title>
	<meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
	<meta property="og:title" content="<?php echo esc_attr($title); ?>">
	<meta name="description" content="Бесплатные объявления о недвижимости по запросу <?php echo esc_attr($title); ?>" />  
	<meta name="twitter:description" content="Бесплатные объявления о недвижимости по запросу <?php echo esc_attr($title); ?>" />	 
	<meta property="og:description" content="Бесплатные объявления о недвижимости по запросу <?php echo esc_attr($title); ?>">
	<?php $current_url = 'https://';
	$current_url .= $_SERVER['HTTP_HOST']; // Get host
	$path = explode( '?', $_SERVER['REQUEST_URI'] ); // Blow up URI
	$current_url .= $path[0]; // Only use the rest of URL - before any parameters
	echo '<meta property="og:url" content="'.esc_url($current_url).'">';
if ($title != 'Недвижимость') {
	echo '<link rel="canonical" href="'.esc_url($current_url).'" />';
} else if(!empty($city)){
	$parent_url = str_replace('nedvizhimost/','',$current_url);
	echo '<link rel="canonical" href="'.esc_url($parent_url).'" />';
}
  
  } elseif (is_category()) {
$taxonomy = get_queried_object();
$singletitle = single_cat_title('',false);
	 ?>
  <title><?php echo esc_html($singletitle); ?> про Недвижимость и Туризм</title>
	<meta name="twitter:title" content="<?php echo esc_attr($singletitle); ?> про Недвижимость и Туризм">
	<meta property="og:title" content="<?php echo esc_attr($singletitle); ?> про Недвижимость и Туризм">
	<meta name="description" content="<?php echo esc_attr($singletitle); ?> про Недвижимость и Туризм" />  
	<meta name="twitter:description" content="<?php echo esc_attr($singletitle); ?> про Недвижимость и Туризм" />	 
	<meta property="og:description" content="<?php echo esc_attr($singletitle); ?> про Недвижимость и Туризм">
	<?php $current_url = 'https://';
	$current_url .= $_SERVER['HTTP_HOST']; // Get host
	$path = explode( '?', $_SERVER['REQUEST_URI'] ); // Blow up URI
	$current_url .= $path[0]; // Only use the rest of URL - before any parameters
	echo '<meta property="og:url" content="'.esc_url($current_url).'">';
	echo '<link rel="canonical" href="'.esc_url($current_url).'" />';
  
  } elseif (is_tag()) { 
	$taxonomy = get_queried_object();
	$singletitle = single_tag_title('',false);
    $desc = strip_tags(term_description( $taxonomy ));
	if ($desc == '') {
	$desc = 'Статьи и новости опубликованные в разделе '.$singletitle;
	}
	?>
	<title><?php echo ucfirst(esc_html($singletitle)); ?> | Статьи и новости раздела </title>
	<meta name="twitter:title" content="<?php echo ucfirst(esc_attr($singletitle)); ?> | Статьи и новости раздела">
	<meta property="og:title" content="<?php echo ucfirst(esc_attr($singletitle)); ?> | Статьи и новости раздела">
	<meta name="description" content="<?php echo esc_attr($desc); ?>" />  
	<meta name="twitter:description" content="<?php echo esc_attr($desc); ?>" />	 
	<?php $current_url = 'https://';
	$current_url .= $_SERVER['HTTP_HOST']; // Get host
	$path = explode( '?', $_SERVER['REQUEST_URI'] ); // Blow up URI
	$current_url .= $path[0]; // Only use the rest of URL - before any parameters ?>
	<meta property="og:description" content="<?php echo esc_attr($desc); ?>">
			<?php 
	echo '<meta property="og:url" content="'.esc_attr($current_url).'">';
	echo '<link rel="canonical" href="'.esc_attr($current_url).'" />';

	?>	
	<?php  }
	elseif (is_attachment()) { 
  
	global $post; 
	$parenttitle = get_the_title($post->post_parent);
	?>
	<meta name="twitter:title" content="Фото из: <?php echo esc_attr($parenttitle); ?>">
	<title>Фото из: <?php echo esc_html($parenttitle); ?></title>
	<meta property="og:title" content="Фото из: <?php echo esc_attr($parenttitle); ?>">
	<meta name="description" content="Фото из: <?php echo esc_attr($parenttitle); ?>" />  
	<meta property="og:description" content="Фото из: <?php echo esc_attr($parenttitle); ?>">
	   <meta name="twitter:description" content="Фото из: <?php echo esc_attr($parenttitle); ?>" />	 
	<?php  
	} elseif (is_single()) {
		
	global $post; ?>
	<title><?php the_title(); ?></title>
	<meta name="twitter:title" content="<?php the_title(); ?>">
	<meta property="og:title" content="<?php the_title(); ?>">
	<meta name="description" content="<?php echo get_the_excerpt(); ?>" />  
	<meta name="twitter:description" content="<?php echo get_the_excerpt(); ?>" />	
	<meta property="og:description" content="<?php echo get_the_excerpt(); ?>">
	<meta property="og:url" content="<?php echo get_permalink(); ?>">
<?php 
if(is_amp_endpoint() == true && $post->post_type == 'post') { 
echo '<script async custom-element="amp-auto-ads" src="https://cdn.ampproject.org/v0/amp-auto-ads-0.1.js"></script>';
} else if($post->post_type == 'post'){ 
echo '<script data-ad-client="ca-pub-5275124683424777" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
};
} elseif (is_singular('page')) {
		
	global $post; ?>
	<title><?php the_title(); ?></title>
	<meta name="twitter:title" content="<?php the_title(); ?>">
	<meta property="og:title" content="<?php the_title(); ?>">
	<meta name="description" content="<?php echo get_the_excerpt(); ?>" />  
	<meta name="twitter:description" content="<?php echo get_the_excerpt(); ?>" />	
	<meta property="og:description" content="<?php echo get_the_excerpt(); ?>">
	<meta property="og:url" content="<?php echo get_permalink(); ?>">
<?php 
if(is_amp_endpoint() == true && $post->post_type == 'post') { echo '<script async custom-element="amp-ad" src="https://cdn.ampproject.org/v0/amp-ad-0.1.js"></script>';
} else if($post->post_type == 'post'){ 
echo '<script data-ad-client="ca-pub-5275124683424777" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>';
};
}; ?>
	
		
		<!-- Chrome, Firefox OS and Opera -->
        <meta name="theme-color" content="#d03030">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#d03030">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#d03030">
	
	<?php if (is_single() && has_post_thumbnail()) {?>
	<meta property="vk:image" content="<?php echo esc_attr(get_the_post_thumbnail_url( $post, 'medium' )); ?>" />
	<meta name="twitter:image" content="<?php echo esc_attr(get_the_post_thumbnail_url( $post, 'medium' )); ?>" />
	<meta property="og:image" content="<?php echo esc_attr(get_the_post_thumbnail_url( $post, 'medium' )); ?>" />
	<?php } else { ?>
	<meta property="vk:image" content="https://media.asp.sale/wp-content/themes/asp/images/banners/real-estate-min.jpg" />
	<meta name="twitter:image" content="https://media.asp.sale/wp-content/themes/asp/images/banners/real-estate-min.jpg" />
	<meta property="og:image" content="https://media.asp.sale/wp-content/themes/asp/images/banners/real-estate-min.jpg" />
	<?php }; ?>	
		
<?php wp_head(); ?>
</head>
<body>
<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}; ?>
<h3> Поделиться </h3>
<?php if (is_tag()) {
$taxonomy = get_queried_object();
$singletitle = myucfirst(single_tag_title('',false)); 
$current_url = 'https://';
	$current_url .= $_SERVER['HTTP_HOST']; // Get host
	$path = explode( '?', $_SERVER['REQUEST_URI'] ); // Blow up URI
	$current_url .= $path[0]; // Only use the rest of URL - before any parameters
?>
<div class="sharcont">
<a class="button sharer icon-whatsapp" target="_blank" href="whatsapp://send?text=<?php echo urlencode(esc_attr($singletitle)); echo urlencode(esc_attr(' '.$current_url)); ?>" data-action="share/whatsapp/share" rel="nofollow noopener"></a><a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(esc_attr(' '.$current_url));?>" rel="nofollow noopener" class="button sharer icon-facebook"></a><a target="_blank" href="https://twitter.com/share?url=<?php echo esc_attr($current_url); ?>&amp;text=<?php echo urlencode(esc_attr($singletitle)); ?>" rel="nofollow noopener" class="button sharer icon-twitter"></a><a target="_blank" href="https://vk.com/share.php?url=<?php  echo esc_attr($current_url); ?>" rel="nofollow noopener" class="button sharer icon-vkontakte"></a>
</div>
<?php } elseif (is_category()) {
$taxonomy = get_queried_object();
$singletitle = myucfirst(single_cat_title('',false)); 
$current_url = 'https://';
	$current_url .= $_SERVER['HTTP_HOST']; // Get host
	$path = explode( '?', $_SERVER['REQUEST_URI'] ); // Blow up URI
	$current_url .= $path[0]; // Only use the rest of URL - before any parameters
?>
<div class="sharcont">
<a class="button sharer icon-whatsapp" target="_blank" href="whatsapp://send?text=<?php echo urlencode(esc_attr($singletitle)); echo urlencode(esc_attr(' '.$current_url)); ?>" data-action="share/whatsapp/share" rel="nofollow noopener"></a><a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(esc_attr(' '.$current_url)); ?>" rel="nofollow noopener" class="button sharer icon-facebook"></a><a target="_blank" href="https://twitter.com/share?url=<?php echo esc_attr($current_url); ?>&amp;text=<?php echo urlencode(esc_attr($singletitle)); ?>" rel="nofollow noopener" class="button sharer icon-twitter"></a><a target="_blank" href="https://vk.com/share.php?url=<?php  echo esc_attr($current_url); ?>" rel="nofollow noopener" class="button sharer icon-vkontakte"></a>
</div>
<?php } elseif (is_tax()) { 
$taxonomy = get_queried_object();
$singletitle = myucfirst(single_term_title('',false));
$city = get_query_var( 'city' );
$ptype = get_query_var( 'ptype' );	
$title = '';
if (!empty($city)) {
	if(array_key_exists($city,CityManager::getCities())) {
		$city = CityManager::getCityBySlug($city);
		$title = $city.' - ';
	}
}
$title .= $singletitle.' ';
if (!empty($ptype)) {
$typetitle = '';
if ($ptype == 'kvartira') $typetitle = 'Квартиру';
if ($ptype == 'dom') $typetitle = 'Дом';
if ($ptype == 'komnata') $typetitle = 'Комнату';	
if ($ptype == 'koikomesto') $typetitle = 'Койко-место';	
if ($ptype == 'nezhiloe') $typetitle = 'Нежилое Помещение';	
if ($ptype == 'uchastok') $typetitle = 'Участок';	
if ($ptype == 'hotel') $typetitle = 'Номер в Отеле';	
if ($ptype == 'novostrojka') $typetitle = 'Квартиру в Новостройке';
$title .= $typetitle;
}

$current_url = 'https://';
	$current_url .= $_SERVER['HTTP_HOST']; // Get host
	$path = explode( '?', $_SERVER['REQUEST_URI'] ); // Blow up URI
	$current_url .= $path[0]; // Only use the rest of URL - before any parameters
?>
<div class="sharcont">
<a class="button sharer icon-whatsapp" target="_blank" href="whatsapp://send?text=<?php echo urlencode(esc_attr($title)); echo urlencode(esc_attr(' '.$current_url)); ?>" data-action="share/whatsapp/share" rel="nofollow noopener"></a><a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(esc_attr(' '.$current_url)); ?>" rel="nofollow noopener" class="button sharer icon-facebook"></a><a target="_blank" href="https://twitter.com/share?url=<?php echo esc_attr($current_url); ?>&amp;text=<?php echo urlencode(esc_attr($title)); ?>" rel="nofollow noopener" class="button sharer icon-twitter"></a><a target="_blank" href="https://vk.com/share.php?url=<?php  echo esc_attr($current_url); ?>" rel="nofollow noopener" class="button sharer icon-vkontakte"></a>
</div>
<?php } elseif (is_single()) { ?>
<div class="sharcont">
<a class="button sharer icon-whatsapp" target="_blank" href="whatsapp://send?text=<?php echo urlencode(esc_attr(get_the_title())); echo urlencode(esc_attr(' '.get_permalink())); ?>" data-action="share/whatsapp/share" rel="nofollow noopener"></a><a target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo get_permalink(); ?>" rel="nofollow noopener" class="button sharer icon-facebook"></a><a target="_blank" href="https://twitter.com/share?url=<?php echo esc_attr(get_permalink()); ?>&amp;text=<?php echo urlencode(esc_attr(get_the_title())); ?>" rel="nofollow noopener" class="button sharer icon-twitter"></a><a target="_blank" href="https://vk.com/share.php?url=<?php echo esc_attr(get_permalink()); ?>" rel="nofollow noopener" class="button sharer icon-vkontakte"></a>
</div>
<?php }; ?>
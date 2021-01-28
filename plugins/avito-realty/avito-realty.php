<?php
/*
Plugin Name: Avito Realty / ASP edition
Description: Adds xml-feed for AVITO, see /feed/avito-realty/
Author: Sam Tyurenkov
Author URI: https://windowspros.ru
Version: 1.3
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Yandex.Realty RSS
add_action('init', 'AddAvitoRSS');
function AddAvitoRSS(){
	add_feed('avito-realty', 'ProceedAvitoRealtyRSS');
}

//AVITO FEED
function ProceedAvitoRealtyRSS(){
http_response_code(200);
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');	
	
echo '<?xml version="1.0" encoding="utf-8"?><Ads formatVersion="3" target="Avito.ru">';

$objects = new WP_Query(
	array('post_type' => 'property',		
		  'post_status' => 'publish',
		  'posts_per_page' => -1,
		  'meta_query' => array(
		  array('key' => 'value_price'),
          array('key' => 'value_area')
          ),
		  'tax_query' => array(
			array(
                'taxonomy'  => 'property-type',
                'field'     => 'id',
				'terms'     => array(23,16),
                'operator'  => 'NOT IN'
				)
			)
		));

while ($objects->have_posts()) : $objects->the_post(); 

	$options = get_property_options(get_post());
	if (!array_key_exists('value_price', $options))	// объявления без указания цены в я.недвижимости запрещены!
		continue;
	if (!array_key_exists('value_area', $options))	// объявления без указания площади в я.недвижимости запрещены!
		continue;
	if (!get_the_author_meta( 'user_phone' ))
		continue;
	if (!array_key_exists('propertytype', $options) || $options['propertytype'] == 'hotel')
                continue;	
	if (!array_key_exists('yandex', $options) || $options['yandex'] == 2)
                continue;				
	if (!array_key_exists('dealtype', $options) || $options['dealtype'] == 'posutochno-snyat')
                continue;
	if (!array_key_exists('locality-name', $options))
                continue;
			
	if ($options['propertytype'] == 'dom' || $options['propertytype'] == 'kvartira') {
		if (!array_key_exists('rooms', $options))	// объявления без указания количества комнат в я.недвижимости запрещены!
		continue;
	}		
			
	if ($options['propertytype'] == 'nezhiloe')
	$category = 'Коммерческая недвижимость';
	elseif ($options['propertytype'] == 'dom')
	$category = 'Дома, дачи, коттеджи';
	elseif ($options['propertytype'] == 'kvartira' || $options['propertytype'] == 'novostrojka')
	$category = 'Квартиры';
	elseif ($options['propertytype'] == 'komnata')
	$category = 'Комнаты'; 
	elseif ($options['propertytype'] == 'uchastok')
	$category = 'Земельные участки';

	$id = get_the_ID();
?>

<Ad>
<Id><?php echo $id; ?></Id>
<Category><?php echo $category; ?></Category>
<OperationType><?php 
if ($options['dealtype'] == 'snyat' || $options['dealtype'] == 'posutochno-snyat') echo 'Сдам';
if ($options['dealtype'] == 'kupit') echo 'Продам';  
?></OperationType>
<ListingFee>Single</ListingFee>
<AdStatus>Free</AdStatus>
<AllowEmail>Нет</AllowEmail>
<ManagerName><?php the_author_meta( 'display_name' ); ?></ManagerName>
<ContactPhone><?php the_author_meta( 'user_phone' ); ?></ContactPhone>
                <?php 
                            if(array_key_exists('address_2', $options)) $address_2 = $options['address_2'];
							if(array_key_exists('address1', $options)) $address1 = $options['address1'];
                ?>
                <?php if ($address_2 != 'null') : ?>
				<Country>Россия</Country>
                 	<Address>Россия, <?php echo $options['locality-name']; ?>, <?php if (array_key_exists('sublocality-name',$options)){ echo $options['sublocality-name'];echo ', ';} ?><?php echo $address_2; ?> <?php echo $address1; ?></Address>
                <?php endif; ?>
<Description>
<![CDATA[
Категории объекта недвижимости: <?php
$terms = get_the_terms( get_the_ID(), 'property-type' );
$output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); 
the_content(); 
?>
]]>
</Description>
<Price><?= $options['value_price']; ?></Price>
<?php
$studio=get_meta('studio');
if (has_term(20 /* Дома */, 'property-type')) {
print_meta('Rooms', 'rooms', 'int');}
elseif (has_term(17 /* квартиры */, 'property-type')) {
print_meta('Rooms', 'rooms', 'int');}
elseif (has_term(15 /* комнаты */, 'property-type')) {
print_meta('Rooms', 'rooms', 'int');}
?>				
	
	<?php // Площадь
	$square = get_meta('value_area');
	if (!has_term(25, 'property-type')) { ?>
	<Square><?php echo $square; ?></Square>	
	<?php if (has_term(20, 'property-type')) { ?>
	<LandArea><?php echo get_meta('lot_area'); ?></LandArea>
	<?php }} else if (has_term(25, 'property-type')) { ?>
	<LandArea><?php echo get_meta('lot_area'); ?></LandArea>
	<?php }; ?>

<?php // Этажи
        if(array_key_exists('floor', $options)) $floor = $options['floor'];
        if(array_key_exists('floors_total', $options)) $floors_total = $options['floors_total'];
        ?>
<?php if ($category != 'Дома, дачи, коттеджи' && $category != 'Земельные участки' && !empty($floor)) : ?>
<Floor><?= $floor; ?></Floor>
<?php endif; ?>
<?php if ($floors_total != 'null' && $floors_total != '') : ?>
<Floors><?= $floors_total; ?></Floors>
<?php endif; ?>	

<?php if ($category == 'Квартиры') { 
echo '<MarketType>Вторичка</MarketType>';
 }; ?>

<?php if ($category == 'Дома, дачи, коттеджи' && array_key_exists('housetype', $options)) { 
echo '<HouseType>'.$options['floors_total'].'</HouseType>';
 }; ?>

<?php if (array_key_exists('propertyrights', $options)) { 
echo '<PropertyRights>'.$options['propertyrights'].'</PropertyRights>';
 }; ?>	

<?php if ($category == 'Дома, дачи, коттеджи' && array_key_exists('houseobjecttype', $options)) { 
echo '<ObjectType>'.$options['houseobjecttype'].'</ObjectType>';
 }; ?> 

<?php if ($category == 'Земельные участки' && array_key_exists('landobjecttype', $options)) { 
echo '<ObjectType>'.$options['landobjecttype'].'</ObjectType>';
 }; ?>  

<?php 	
if ($options['dealtype'] == 'snyat' ) {
	echo '<LeaseType>На длительный срок</LeaseType>';
} else if ($options['dealtype'] == 'posutochno-snyat') {
	echo '<LeaseType>Посуточно</LeaseType>';
};
?>

<SafeDemonstration>Могу провести</SafeDemonstration>
<Images>
<?php 
$attachments = property_attachments(get_post());
                if ($attachments) {
				$index = count($attachments);
                    while($index) {	
						$src = wp_get_attachment_image_src( $attachments[--$index]->ID, 'medium')[0];
						echo '<Image url="'.$src.'" />';
                    }

                }
?>
</Images>
</Ad>

<?php endwhile; echo '</Ads>';
}

?>
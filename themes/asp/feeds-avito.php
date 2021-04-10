<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
};

http_response_code(200);
header('Content-Type: application/xml; charset=utf-8');
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');	

preg_match('/[0-9]+/', $_SERVER['REQUEST_URI'], $matches);	
$author_id = $matches[0];
if(is_numeric($author_id) == false) return;
$xmlhash = get_the_author_meta( 'xmlhash', $author_id);
$xkey = get_query_var('xkey');

if($xmlhash != $xkey && current_user_can('editor' || 'administrator') == false) return;
	
echo '<?xml version="1.0" encoding="utf-8"?><Ads formatVersion="3" target="Avito.ru">';

$objects = wp_cache_get( 'feed_avito_'.$author_id );
if ( false === $objects ) {
	
$managers = explode(',', get_the_author_meta( 'managers', $author_id));
array_push($managers, $author_id); 
$managers = array_filter(array_unique($managers));

$objects = new WP_Query(
	array('post_type' => 'property',
		  'author__in' => $managers, 
		  'post_status' => 'publish',
		  'posts_per_page' => -1,
		  'meta_query' => array(
		  array('key' => 'value_price'),
          array('key' => 'value_area'),
		  array('key' => 'avito',
				'value' => array(1,3,4)
		  ),
		  'relation' => 'AND'
          ),
		  'tax_query' => array(
			array(
                'taxonomy'  => 'property-type',
                'field'     => 'id',
				'terms'     => array(23),
                'operator'  => 'NOT IN'
				)
			)
		));
wp_cache_set( 'feed_avito_'.$author_id, $objects );								
}
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
	if (!array_key_exists('avito', $options) || $options['avito'] == 2)
                continue;				
	if (!array_key_exists('dealtype', $options))
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
                 	<Address>Россия, <?php echo $options['locality-name']; ?>, <?php if (array_key_exists('sublocality-name',$options)){ echo $options['sublocality-name'];echo ', ';} ?><?php echo $address_2; ?> <?php echo $address1; ?></Address>
                <?php endif; ?>
<Description>
<![CDATA[
<p>Категории объекта недвижимости:
<?php
$terms = get_the_terms( get_the_ID(), 'property-type' );
$output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); 
echo '</p>';
echo str_replace('"','',get_the_content()); 
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
if(array_key_exists('market_type', $options)) {
$market_type = $options['market_type'];
echo '<MarketType>'.esc_html($market_type).'</MarketType>';
}
 }; ?>

<?php if (($category == 'Квартиры' || $category == 'Комнаты') && array_key_exists('housetype', $options)) { 
echo '<HouseType>'.$options['housetype'].'</HouseType>';
 }; ?>
<?php if($market_type == 'Новостройка') { 
if (array_key_exists('avitokorpus', $options))
echo '<NewDevelopmentId>'.esc_html($options['avitokorpus']).'</NewDevelopmentId>';
else if (array_key_exists('avitonewdev', $options)) 
echo '<NewDevelopmentId>'.esc_html($options['avitonewdev']).'</NewDevelopmentId>';
};
?>

<?php 
$authortype = get_the_author_meta( 'authortype' );
if ($authortype == 'Агент') $authortype = 'Посредник';
if ($authortype) { 
echo '<PropertyRights>'.esc_html($authortype).'</PropertyRights>';
 }; ?>	

<?php if ($category == 'Дома, дачи, коттеджи' && array_key_exists('houseobjecttype', $options)) { 
echo '<ObjectType>'.esc_html($options['houseobjecttype']).'</ObjectType>';
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
<?php if (array_key_exists('zalog', $options)) {  
$diffzalog = $options['value_price'] - $options['zalog'];
if ($diffzalog >= $options['value_price']) $diffzalog = 'Без залога';
else if ($diffzalog >= 0) $diffzalog = '1 месяц';
else if ($diffzalog >= $options['value_price']*-1) $diffzalog = '2 месяца';
?>
<LeaseDeposit>
<?php echo esc_html($diffzalog); ?>
</LeaseDeposit>
<?php }; ?>

<?php if (array_key_exists('avitoid', $options) && ($options['avitoid'] > 0) && ($options['avitoid'] != '')) {  ?>
<AvitoId><?php echo esc_html($options['avitoid']); ?></AvitoId>
<?php }; ?>

<?php 
if (array_key_exists('agent-fee', $options) && ($options['agent-fee'] > 0))   
$feepercent = intval($options['value_price']*100/$options['agent-fee']);
else 
$feepercent = 0;
?>
<LeaseCommissionSize>
<?php echo esc_html($feepercent); ?>
</LeaseCommissionSize>

<?php if (array_key_exists('online-show', $options)) { 
echo '<SafeDemonstration>'.$options['online-show'].'</SafeDemonstration>';
}; ?>
<Images>
<?php 
$attachments = property_attachments(get_post());
				
				if (has_post_thumbnail()) {
						echo '<Image url="'.get_the_post_thumbnail_url( get_post()->ID, 'medium' ).'" />';
				};

                if ($attachments) {
				$index = count($attachments);
                    while($index) {	
						$src = wp_get_attachment_image_src( $attachments[--$index]->ID, 'medium')[0];
						echo '<Image url="'.$src.'" />';
                    }

                }
?>
</Images>
<?php if (array_key_exists('youtube-video', $options)) { ?>
<VideoURL><?php echo $options['youtube-video']; ?></VideoURL>
<?php }; ?>
</Ad>

<?php endwhile; echo '</Ads>';

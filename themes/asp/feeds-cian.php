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


echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<feed>
<feed_version>2</feed_version>
<?php 

$objects = wp_cache_get( 'feed_cian_'.$author_id );
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
		  array('key' => 'cian',
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

wp_cache_set( 'feed_cian_'.$author_id );								
}

while ($objects->have_posts()) : $objects->the_post(); ?>

<?php
	$options = get_property_options(get_post());
	if (!array_key_exists('value_price', $options))	// объявления без указания цены в я.недвижимости запрещены!
		continue;
	if (!array_key_exists('value_area', $options))	// объявления без указания площади в я.недвижимости запрещены!
		continue;
	if (!get_the_author_meta( 'user_phone' ))
		continue;
	if (!array_key_exists('propertytype', $options) || $options['propertytype'] == 'hotel')
                continue;	
	if (!array_key_exists('cian', $options) || $options['cian'] == 2)
                continue;				
	if (!array_key_exists('dealtype', $options))
                continue;
	if (!array_key_exists('locality-name', $options))
                continue;
			
	if ($options['propertytype'] == 'dom' || $options['propertytype'] == 'kvartira') {
		if (!array_key_exists('rooms', $options))	// объявления без указания количества комнат в я.недвижимости запрещены!
		continue;
	}		
			
	if ($options['propertytype'] == 'nezhiloe') {
		
	if ($options['commercial-type'] == 'business')
	$category = 'business';
	elseif ($options['commercial-type'] == 'office')
	$category = 'office';
	elseif ($options['commercial-type'] == 'land')
	$category = 'commercialLand';
	elseif ($options['commercial-type'] == 'free purpose')
	$category = 'freeAppointmentObject';
	elseif ($options['commercial-type'] == 'warehouse')
	$category = 'warehouse';
	elseif ($options['commercial-type'] == 'retail')
	$category = 'shoppingArea';
	elseif ($options['commercial-type'] == 'manufacturing')
	$category = 'industry';
	else
	continue;

	}

	if ($options['propertytype'] == 'dom')
	$category = 'house';
	elseif ($options['propertytype'] == 'kvartira')
	$category = 'flat';
	elseif ($options['propertytype'] == 'komnata')
	$category = 'room'; 
	elseif ($options['propertytype'] == 'uchastok')
	$category = 'land';
	
	if ($options['dealtype'] == 'kupit')
	$category .= 'Sale';
	else
	$category .= 'Rent';	

	if(array_key_exists('market_type',$options) && $options['market_type'] == 'Новостройка') {
		$category = 'newBuilding'.ucfirst($category);
	}

	$id = get_the_ID();
?>

<object>
<ExternalID><?php echo esc_html($id); ?></ExternalID>
<Description>
<![CDATA[
<p>Категории объекта недвижимости: 
<?php
$terms = get_the_terms( get_the_ID(), 'property-type' );
$output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); 
echo '</p>';
the_content(); 
?>
]]>
</Description>
<?php 
if(array_key_exists('address_2', $options)) $address_2 = $options['address_2'];
if(array_key_exists('address1', $options)) $address1 = $options['address1'];
?>
<?php if ($address_2 != 'null') : ?>
<Address><?php echo $options['locality-name'].', '; if (array_key_exists('sublocality-name',$options)){ echo $options['sublocality-name'];echo ', ';} ?><?php echo $address_2; ?> <?php echo $address1; ?></Address>
<?php endif; ?>
<Phones>
      <PhoneSchema>
        <CountryCode>+7</CountryCode>
        <Number><?php echo preg_replace('/^(\+7|8|7)/','',get_the_author_meta( 'user_phone' )); ?></Number>
      </PhoneSchema>
</Phones>

    <?php 
	if (array_key_exists('zalog', $options)) {
		$zalog = 1;
		$zalogsum = $options['zalog'];
	} else {
		$zalog = 0;
	};
	?>
	
	<Category>
	<?php echo esc_html($category); ?>
	</Category>

<?php if($options['locality-name'] == 'Москва' && array_key_exists('metro_msk', $options)) : 
$metro = get_field_object('metro_msk');  
?>
<Undergrounds>
      <UndergroundInfoSchema>
        <Id><?php echo esc_html($metro['value']['value']); ?></Id>
      </UndergroundInfoSchema>
    </Undergrounds>	
<?php endif; ?>
<?php if($options['locality-name'] == 'Санкт-Петербург' && array_key_exists('metro_spb', $options)) : 
$metro = get_field_object('metro_spb');  
?>
<Undergrounds>
      <UndergroundInfoSchema>
        <Id><?php echo esc_html($metro['value']['value']); ?></Id>
      </UndergroundInfoSchema>
    </Undergrounds>	
<?php endif; ?>


	<SubAgent>
		<Email><?php the_author_meta( 'user_email'); ?></Email>
		<Phone><?php the_author_meta( 'user_phone' ); ?></Phone>
		<FirstName><?php the_author_meta( 'display_name' ); ?></FirstName>
		<AvatarUrl><?php echo esc_html(get_avatar_url( $author_id , array('size' => 150,) )); ?></AvatarUrl>
	</SubAgent>

<BargainTerms>
<Price>
<?php echo $options['value_price'] ?>
</Price>
<Currency>
rur
</Currency>
<?php if(array_key_exists('agent-fee', $options)) : ?>
<AgentBonus>
<Value>
<?php echo esc_html($options['agent-fee']); ?>
</Value>
<PaymentType>
fixed
</PaymentType>
<Currency>
rur
</Currency>
</AgentBonus>
<?php endif; ?>
</BargainTerms>
	

<?php // Площадь
	$square = get_meta('value_area');
	if (!has_term(25, 'property-type')) { ?>
	<TotalArea	>
	<?php echo $square; ?>
	</TotalArea	>
	<?php if (has_term(20, 'property-type')) { ?>
	<Land>
	<Area>
	<?php echo get_meta('lot_area'); ?>
	</Area>
	<AreaUnitType>
	sotka
	</AreaUnitType>
	</Land>
	<?php }} else if (has_term(25, 'property-type')) { ?>
	<Land>
	<Area>
	<?php echo floatval($square)*0.01; ?>
	</Area>
	<AreaUnitType>
	sotka
	</AreaUnityType>
	</Land>
	<?php }; ?>

<?php if ($options['propertytype'] != 'uchastok') : ?>
<FlatRoomsCount><?php 
if (has_term(15 /* Комнаты */, 'property-type') || has_term(23 /* Отели */, 'property-type')) {
	echo 1;
} else {
echo get_meta('rooms'); 
}
?>
</FlatRoomsCount>
<?php endif; ?>
<?php // Этажи
        if(array_key_exists('floor', $options)) $floor = $options['floor'];
        if(array_key_exists('floors_total', $options)) $floors_total = $options['floors_total'];
        ?>
		
		
<?php if (!empty($floor)) : ?>
<FloorNumber><?= $floor; ?></FloorNumber>
<?php endif; ?>

<Building>
<?php if ($floors_total != 'null' && $floors_total != '') : ?>

<FloorsCount><?php echo $floors_total; ?></FloorsCount>
<?php endif; ?>
<?php // Коммерческая
        $dealstatus = get_meta('commercial-type');
        $buildingname = get_meta('building-name');
		$yabid = get_meta('yandex-building-id');
		$bstate = get_meta('building-state');
		$byear = get_meta('built-year');
		$rquarter = get_meta('ready-quarter');
        ?>
</Building>

<?php // Этажи
        if(array_key_exists('ciannewdev', $options)) : ?>
		
		<?php
		$ciannewdev = $options['ciannewdev'];
		?>

<JKSchema>
      <Id><?php echo esc_html($ciannewdev); ?></Id>
	  <?php if(array_key_exists('ciankorpus', $options)) { ?>
      <House>
        <Id><?php echo esc_html($options['ciankorpus']); ?></Id>
      </House>
	  <?php }; ?>
</JKSchema>
<?php endif; ?>

<Photos>
<?php 
$attachments = property_attachments(get_post());

				if (has_post_thumbnail()) {
						echo '<PhotoSchema><FullUrl>'.get_the_post_thumbnail_url( get_post()->ID, 'medium' ).'</FullUrl><IsDefault>true</IsDefault></PhotoSchema>';		
				};
                if ($attachments) {
				$index = count($attachments);
                    while($index) {	
						$src = wp_get_attachment_image_src( $attachments[--$index]->ID, 'medium')[0];
						echo '<PhotoSchema><FullUrl>'.$src.'</FullUrl><IsDefault>true</IsDefault></PhotoSchema>';
                    }

                }
		?>
</Photos>
<?php if (array_key_exists('youtube-video', $options)) { ?>
<Videos>
      <VideoSchema>
        <Url><?php echo $options['youtube-video']; ?></Url>
      </VideoSchema>
</Videos>
<?php }; ?>
</object>
<?php endwhile; wp_reset_postdata(); ?>
</feed>
<?php 
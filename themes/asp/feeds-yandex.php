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
<realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06">
<generation-date><?php echo date('c'); ?></generation-date>
<?php  
$objects = wp_cache_get( 'feed_yandex_'.$author_id );
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
		  array('key' => 'yandex',
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
		
wp_cache_set( 'feed_yandex_'.$author_id, $objects);								
}

while ($objects->have_posts()) : $objects->the_post(); ?>
<?php
	$options = get_property_options(get_post());
	 if (!array_key_exists('value_price', $options))	// объявления без указания цены в я.недвижимости запрещены!
	 		error_log('missing value_price');	
	 if (!array_key_exists('value_area', $options))	// объявления без указания площади в я.недвижимости запрещены!
	 		error_log('missing value_area');	
	 if (!get_the_author_meta( 'user_phone' ))
	 		error_log('missing user_phone');	
	if (!array_key_exists('propertytype', $options) || $options['propertytype'] == 'hotel')
			error_log('missing propertytype');		
	if (!array_key_exists('yandex', $options) || $options['yandex'] == 2)
				error_log('missing yandex');				
	 if (!array_key_exists('dealtype', $options))
	 			error_log('missing dealtype');
	 if (!array_key_exists('locality-name', $options))
                 error_log('missing locality');
			
	 if ($options['propertytype'] == 'dom' || $options['propertytype'] == 'kvartira') {
	 	if (!array_key_exists('rooms', $options))	// объявления без указания количества комнат в я.недвижимости запрещены!
	 	continue;
	 }		
			
	if ($options['propertytype'] == 'nezhiloe')
	$category = 'коммерческая';
	elseif ($options['propertytype'] == 'dom')
	$category = 'дом';
	elseif ($options['propertytype'] == 'kvartira' || $options['propertytype'] == 'novostrojka')
	$category = 'квартира';
	elseif ($options['propertytype'] == 'komnata')
	$category = 'комната'; 
	elseif ($options['propertytype'] == 'uchastok')
	$category = 'земельный участок';


	$id = get_the_ID();
?>

<offer internal-id="<?php echo $id; ?>">
    <?php 
	if (array_key_exists('zalog', $options) && is_numeric($options['value_price']) && ($options['value_price'] > 0))  {
		$zalog = 1;
		$zalogsum = intval(intval($options['zalog'])*100/intval($options['value_price']));
	} else {
		$zalog = 0;
	};
if ($options['dealtype'] == 'snyat' || $options['dealtype'] == 'posutochno-snyat') {
	echo '<type>аренда</type>';
	echo '<rent-pledge>'.$zalog.'</rent-pledge>';
} else {
	echo '<type>продажа</type>';
};

		if ($category == 'коммерческая' && array_key_exists('commercial-type', $options)){
		echo '<commercial-type>'.$options['commercial-type'].'</commercial-type>';
		if (!has_term(21, 'property-type') && $zalog > 0){
		echo '<security-payment>'.esc_html($zalogsum).'</security-payment>';
		}
		} else  {
		echo '<property-type>жилая</property-type>';
		};
		if (array_key_exists('agent-fee', $options) && ($options['value_price'] > 0) && ($options['value_price'] != '')) {
			echo '<agent-fee>'.(intval(intval($options['agent-fee'])*100/intval($options['value_price']))).'</agent-fee>';
		};
		
	if (array_key_exists('kommun-platezh', $options) && $options['kommun-platezh'] == 'включены') {
	echo '<utilities-included>1</utilities-included>';
	} else if (array_key_exists('kommun-platezh', $options) && $options['kommun-platezh'] == 'не включены') {
	echo '<utilities-included>0</utilities-included>';
	};
		?>
	<category>
	<?php echo esc_html($category); ?>
	</category>
	<url><?php the_permalink(); ?></url>
	<creation-date><?php the_time('c'); ?></creation-date>
	<last-update-date><?php the_modified_time('c'); ?></last-update-date>
	<manually-added>да</manually-added>
	<location>
		<country>Россия</country>
		<locality-name><?php echo $options['locality-name']; ?></locality-name>
                <?php 
                            if(array_key_exists('address_2', $options)) $address_2 = $options['address_2'];
							if(array_key_exists('address1', $options)) $address1 = $options['address1'];
                ?>
                <?php if ($address_2 != 'null') : ?>
<address>
<?php if (array_key_exists('sublocality-name',$options)): ?>
<?php echo esc_html($options['sublocality-name']).', '; ?>
<?php endif; ?>
<?php echo $address_2.', '; ?> <?php echo $address1; ?></address>
                <?php endif; ?>
				<?php if($options['locality-name'] == 'Москва' && array_key_exists('metro_msk', $options)) : 
$metro = get_field_object('metro_msk');  
?>
<metro>
      <name>
        <?php echo esc_html($metro['value']['label']); ?>
      </name>
</metro>	
<?php endif; ?>
<?php if($options['locality-name'] == 'Санкт-Петербург' && array_key_exists('metro_spb', $options)) : 
$metro = get_field_object('metro_spb');  
?>
<metro>
      <name>
        <?php echo esc_html($metro['value']['label']); ?>
      </name>
</metro>
<?php endif; ?>
	</location>

	<sales-agent>
		<phone><?php the_author_meta( 'user_phone' ); ?></phone>
		<category>агентство</category>
		<url><?php echo esc_html(get_author_posts_url( get_the_author_meta( "ID" ) )); ?></url>
		<email><?php the_author_meta( 'user_email'); ?></email>
		<photo><?php echo esc_html(get_avatar_url( get_the_author_meta( "ID" ) , array('size' => 150,) )); ?></photo>
	</sales-agent>
<?php if ($options['propertytype'] == 'novostrojka') : ?>
	<new-flat>да</new-flat>
<?php endif; ?>


	<price>
		<value><?php echo $options['value_price']; ?></value>
		<currency>RUB</currency>
		<?php if ($options['dealtype'] == 'posutochno-snyat') : ?>
		<period>day</period>
		<?php endif; ?>
	</price>

<?php // Площадь
	$square = get_meta('value_area');
	if (!has_term(25, 'property-type')) { ?>
	<area>
		<value><?php echo $square; ?></value>
		<unit>кв.м</unit>
	</area>
	<?php if (has_term(20, 'property-type') && array_key_exists('lot_area', $options)) { ?>
	<lot-area>
		<value><?php echo $options['lot_area']; ?></value>
		<unit>cотка</unit>
	</lot-area>
	<?php }} else if (has_term(25, 'property-type')) { ?>
	<lot-area>
		<value><?php echo $square; ?></value>
		<unit>кв.м</unit>
	</lot-area>
	<?php }; ?>

<?php
$studio=get_meta('studio');
if (has_term(20 /* Дома */, 'property-type')) {
print_meta('rooms', 'rooms', 'int');}
elseif (has_term(17 /* квартиры */, 'property-type') && $studio != '1') {
print_meta('rooms', 'rooms', 'int');}
elseif (has_term(17 /* квартиры */, 'property-type') && $studio == '1' ) {
print_meta('studio','studio', 'int');}
elseif (has_term(17 /* квартиры */, 'property-type') && $studio == 'Да' ) {
echo '<new-flat>1</new-flat>';}
elseif (has_term(15 /* комнаты */, 'property-type')) {
print_meta('rooms', 'rooms', 'int');}
    ?>
<?php if ($studio != '1' && $category != 'земельный участок') : ?>
<rooms-offered><?php 
if (has_term(15 /* Комнаты */, 'property-type') || has_term(23 /* Отели */, 'property-type')) {
	echo 1;
} else {
echo get_meta('rooms'); 
}
?></rooms-offered>
<?php endif; ?>
<?php // Этажи
        if(array_key_exists('floor', $options)) $floor = $options['floor'];
        if(array_key_exists('floors_total', $options)) $floors_total = $options['floors_total'];
        ?>
<?php if ($category != 'дом' && $category != 'земельный участок' && !empty($floor)) : ?>
<floor><?= $floor; ?></floor>
<?php endif; ?>
<?php if ($floors_total != 'null' && $floors_total != '') : ?>
<floors-total><?php echo $floors_total; ?></floors-total>
<?php endif; ?>
<?php // Коммерческая
        $dealstatus = get_meta('commercial-type');
        $buildingname = get_meta('building-name');
		$yabid = get_meta('yandex-building-id');
		$bstate = get_meta('building-state');
		$byear = get_meta('built-year');
		$rquarter = get_meta('ready-quarter');
        ?>

<!--<vas>premium</vas>-->
<?php if ($buildingname != 'null' && $buildingname != '') : ?>
<building-name><?php echo $buildingname; ?></building-name>
<?php endif; ?>
<?php if ($yabid != 'null' && $yabid != '') : ?>
<yandex-building-id><?php echo $yabid; ?></yandex-building-id>
<?php endif; ?>
<?php if ($bstate != 'null' && $bstate != '') : ?>
<building-state><?php echo $bstate; ?></building-state>
<?php endif; ?>
<?php if ($byear != 'null' && $byear != '') : ?>
<built-year><?php echo $byear; ?></built-year>
<?php endif; ?>
<?php if ($rquarter != 'null' && $rquarter != '') : ?>
<ready-quarter><?php echo $rquarter; ?></ready-quarter>
<?php endif; ?>


<description>
<![CDATA[
<p>Категории объекта недвижимости:
<?php
$terms = get_the_terms( get_the_ID(), 'property-type' );
$output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output);
echo '</p>'; 
echo str_replace('"','',get_the_content());  ?>
]]>
</description>
<?php if (array_key_exists('youtube-video', $options) || (array_key_exists('online-show', $options) && ($options['online-show'] == 'Могу показать'))) : ?>
<video-review>
<?php if (array_key_exists('youtube-video', $options)) { ?>
<youtube-video-review-url><?php echo $options['youtube-video']; ?></youtube-video-review-url>
<?php }; 
	  if (array_key_exists('online-show', $options) && ($options['online-show'] == 'Могу показать')) { ?>
<online-show>1</online-show>
<?php }; ?>
</video-review>
<?php endif; 

$attachments = property_attachments(get_post());
				if (has_post_thumbnail()) {
						echo '<image>'.get_the_post_thumbnail_url( get_post()->ID, 'medium' ).'</image>';		
				};
                if ($attachments) {
				$index = count($attachments);
                    while($index) {	
						$src = wp_get_attachment_image_src( $attachments[--$index]->ID, 'medium')[0];
						echo '<image>'.$src.'</image>';
                    }

                }
		?>
</offer>
<?php endwhile; wp_reset_postdata(); ?>
</realty-feed>
<?php 
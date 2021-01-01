<?php
/*
Plugin Name: Yandex Realty Feed / ASP
Description: Adds xml-feed for Yandex.Realty - see /feed/yandex-realty/ 
Author: Sam Tyurenkov
Author URI: https://windowspros.ru
Version: 1.3
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Yandex.Realty RSS
add_action('init', 'AddYandexRSS');
function AddYandexRSS(){
	add_feed('yandex-realty', 'ProceedYandexRealtyRSS');
}

//REALTY FEED
function ProceedYandexRealtyRSS()
{
http_response_code(200);
header('Content-Type: '.feed_content_type('rss-http').'; charset='.get_option('blog_charset'), true);
header_remove('Link'); 
header_remove('Etag'); 
header_remove('set-cookie');
header_remove('access-control-allow-origin');	
	
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06">
<generation-date><?php echo date('c'); ?></generation-date>
<?php 
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
				'terms'     => array(23),
                'operator'  => 'NOT IN'
				)
			)
		));

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
	if (array_key_exists('zalog', $options)) {
		$zalog = 1;
		$zalogsum = $options['zalog'];
	} else {
		$zalog = 0;
	};
	$fee = 0;
	if (array_key_exists('agent-fee', $options)) {
		$fee = $fee + (int)substr($options['agent-fee'],0,-1);
	}; 
	if (array_key_exists('special-fee', $options)) {
		$fee = $fee + (int)substr($options['special-fee'],0,-1);
	}
if ($options['dealtype'] == 'snyat' || $options['dealtype'] == 'posutochno-snyat') {
	echo '<type>аренда</type>';
	echo '<rent-pledge>'.$zalog.'</rent-pledge>';
} else {
	echo '<type>продажа</type>';
};

		if ($category == 'коммерческая' && array_key_exists('commercial-type', $options)){
		echo '<commercial-type>'.$options['commercial-type'].'</commercial-type>';
		if (!has_term(21, 'property-type') && $zalog > 0){
		echo '<security-payment>'.substr($zalogsum,0,-1).'</security-payment>';
		}
		} else  {
		echo '<property-type>жилая</property-type>';
		};
		if ($fee > 0) {
			echo '<commission>'.$fee.'</commission>';
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
                 <address><?php if (array_key_exists('sublocality-name',$options)){ echo $options['sublocality-name'];echo ', ';} ?><?php echo $address_2; ?> <?php echo $address1; ?></address>
                <?php endif; ?>
	</location>

	<sales-agent>
		<phone><?php the_author_meta( 'user_phone' ); ?></phone>
		<category>агентство</category>
		<organization>ASP Недвижимость</organization>
		<url>https://asp.sale</url>
		<email>info@asp.sale</email>
		<photo>http://asp.sale/wp-content/uploads/2016/03/ASP-LOGO-NORMAL.png</photo>
	</sales-agent>
<?php if ($options['propertytype'] == 'novostrojka') : ?>
	<new-flat>да</new-flat>
<?php endif; ?>


	<price>
		<value><?php echo $options['value_price'] ?></value>
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
	<?php if (has_term(20, 'property-type')) { ?>
	<lot-area>
		<value><?php echo get_meta('lot_area'); ?></value>
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
Категории объекта недвижимости: <?php
$terms = get_the_terms( get_the_ID(), 'property-type' );
$output = array(); foreach($terms as $term){ $output[] = $term->name;} echo implode(', ', $output); ?>

<?php the_content(); ?>
]]>
</description>
<video-review>
<online-show>1</online-show>
</video-review>
<?php 
$attachments = property_attachments(get_post());
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
}
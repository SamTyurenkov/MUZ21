<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php

//HELPERS FOR EXTERNALS METHODS
function check_expire($expiry) {
$diff = intval(time()) - intval($expiry);
if ($diff > 9000 && empty($yandexerrors) && empty($yandexdata)) {
return true;
} else {
return false;	
}
}

function curlCheck(){
    return function_exists('curl_version');
}

function myucfirst($str) {
    $fc = mb_strtoupper(mb_substr($str, 0, 1));
    return $fc.mb_substr($str, 1);
}

//CHECK IF CLIENT IS ON MOBILE DEVICE
function my_wp_is_mobile() {
    static $is_mobile;

    if ( isset($is_mobile) )
        return $is_mobile;

    if ( empty($_SERVER['HTTP_USER_AGENT']) ) {
        $is_mobile = false;
    } elseif (
        strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false ) {
            $is_mobile = true;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') == false) {
            $is_mobile = true;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

//CHECK IF POST HAS ATTACHEMENTS
function property_attachments($post) {

        $attachments = get_posts( array(
            'post_type' => 'attachment',
            'posts_per_page' => -1,
            'post_parent' => $post->ID,
            'exclude'     => get_post_thumbnail_id()
        ) );
		return $attachments;

}

//DISPLAY PROPERTY OPTIONS
function property_options($post) {
$response = array();
$array = get_post_meta($post->ID,'',true);
$cats = get_the_terms( $post, 'property-type' );
	
	foreach ($cats as $cat) {
	if (preg_match('/(kupit|posutochno-snyat|snyat)/i', $cat->slug) == 1) {
		$dtype = $cat->slug;
	} else if (preg_match('/(dom|kvartira|nezhiloe|uchastok|komnata|hotel|novostrojka|koikomesto)/i', $cat->slug) == 1) {
		$ptype = $cat->slug;
	}
	}
$norooms = array('uchastok','koikomesto', 'hotel','komnata');
$nofloor = array('uchastok','dom');
$nokrovatis = array('uchastok','koikomesto', 'nezhiloe');
$notransfer = array('snyat','kupit');
	
if (array_key_exists('locality-name', $array)) $city = $array['locality-name'][0];	
if (array_key_exists('sublocality-name', $array)) $subcity = $array['sublocality-name'][0];
if (array_key_exists('address_2', $array)) $street = $array['address_2'][0];
if (array_key_exists('address1', $array)) $housen = $array['address1'][0];
if (array_key_exists('rooms', $array) && !in_array($ptype,$norooms)) $rooms = $array['rooms'][0];	
if (array_key_exists('floor', $array) && !in_array($ptype,$nofloor)) $floor = $array['floor'][0];
if (array_key_exists('floors_total', $array) && $ptype != 'uchastok') $floors = $array['floors_total'][0];
if (array_key_exists('value_area', $array)) $square = $array['value_area'][0];
if (array_key_exists('lot_area', $array)) $lotarea = $array['lot_area'][0];
if (array_key_exists('internet', $array) && $ptype != 'uchastok') $internet = $array['internet'][0];
if (array_key_exists('television', $array) && $ptype != 'uchastok') $tv = $array['television'][0];
if (array_key_exists('krovatis', $array) && !in_array($ptype,$nokrovatis)) $krovatis = $array['krovatis'][0]; 
if (array_key_exists('min_stay', $array) && !in_array($dtype,$notransfer)) $min_stay = $array['min_stay'][0];
if (array_key_exists('kommun-platezh', $array) && $dtype != 'kupit') $kommunal = $array['kommun-platezh'][0];
if (array_key_exists('zalog', $array) && $dtype != 'kupit') $zalog = $array['zalog'][0];
if (array_key_exists('transfer', $array) && !in_array($dtype,$notransfer)) $transfer = $array['transfer'][0];

if (!empty($city) && !empty($subcity)) {
	$response['city'] = '<i class="icon-location"></i> '.$city.', '.$subcity;	
} else if (!empty($city)) {
	$response['city'] = '<i class="icon-location"></i> '.$city;
}

$price = number_format($array['value_price'][0]); 
if (!empty($price)) {
	$response['price'] = '<i class="icon-rouble"></i> '.$price;
	if (has_term( 16, 'property-type', $post->ID )) $response['price'] .= '/сутки';
	if (has_term( 19, 'property-type', $post->ID )) $response['price'] .= '/месяц';
}


//if (!empty($street)) $response['city'] .= ', '.$street;
//if (!empty($housen)) $response['city'] .= ' '.$housen;
if (!empty($rooms)) $response['rooms'] = '<i class="icon-cube"></i> Комнат: '.$rooms;
if (!empty($square)) $response['square'] = '<i class="icon-resize-full-alt"></i> '.$square.' кв.м.';
if ($ptype == 'dom' && !empty($lotarea)) $response['square'] .= ' +'.$lotarea.' соток';
if (!empty($floor) && !empty($floors)) $response['floor'] = '<i class="icon-building-filled"></i> '.$floor.' этаж из '.$floors;
if (!empty($floors) && empty($floor)) $response['floors'] = '<i class="icon-building-filled"></i> '.$floors.' этажа';

if (!empty($internet)) $response['wifi'] = '<i class="icon-wifi"></i> '.$internet;
if (!empty($tv)) $response['tv'] = '<i class="icon-television"></i> '.$tv;
if (!empty($krovatis)) $response['krovatis'] = '<i class="icon-bed"></i> До '.$krovatis.' человек';
if (!empty($min_stay)) $response['min_stay'] = '<i class="icon-clock"></i> От '.$min_stay.' суток';
if (!empty($kommunal)) $response['kommunal'] = '<i class="icon-gauge"></i> Комм. '.$kommunal;
if (!empty($zalog)) $response['zalog'] = '<i class="icon-shield"></i> Залог '.$zalog;
if (!empty($transfer)) $response['transfer'] = '<i class="icon-cab"></i> '.$transfer;

return $response;

}

//GET PROPERTY OPTIONS
function get_property_options($post) {
$response = array();

$array = get_post_meta($post->ID, '', true);
$cats = get_the_terms( $post, 'property-type' );
$cats2array = Array();
	
	foreach ($cats as $cat) {
	if (preg_match('/(kupit|posutochno-snyat|snyat)/i', $cat->slug) == 1) {
		$dtype = $cat->slug;
	} else if (preg_match('/(dom|kvartira|nezhiloe|uchastok|komnata|hotel|koikomesto)/i', $cat->slug) == 1) {
		$ptype = $cat->slug;
	}
	}
$cities = CityManager::getCities();

if (!empty($array['locality-name'][0]) && in_array($array['locality-name'][0],$cities)) $response['locality-name'] = $array['locality-name'][0]; 
if (!empty($array['sublocality-name'][0])) $response['sublocality-name'] = $array['sublocality-name'][0];
if (!empty($array['rooms'][0])) $response['rooms'] = $array['rooms'][0];
if (!empty($array['floor'][0])) $response['floor'] = $array['floor'][0];
if (!empty($array['floors_total'][0])) $response['floors_total'] = $array['floors_total'][0]; 
if (!empty($array['value_area'][0])) $response['value_area'] = $array['value_area'][0]; 
if (!empty($array['lot_area'][0])) $response['lot_area'] = $array['lot_area'][0];
if (!empty($array['internet'][0])) $response['internet'] = $array['internet'][0]; 
if (!empty($array['television'][0])) $response['television'] = $array['television'][0];
if (!empty($array['krovatis'][0])) $response['krovatis'] = $array['krovatis'][0]; 
if (!empty($array['min_stay'][0])) $response['min_stay'] = $array['min_stay'][0];
if (!empty($array['kommun-platezh'][0])) $response['kommun-platezh'] = $array['kommun-platezh'][0];
if (!empty($array['zalog'][0])) $response['zalog'] = $array['zalog'][0];
if (!empty($array['agent-fee'][0])) $response['agent-fee'] = $array['agent-fee'][0];
if (!empty($array['transfer'][0])) $response['transfer'] = $array['transfer'][0];
if (!empty($array['online-show'][0])) $response['online-show'] = $array['online-show'][0];
if (!empty($array['value_price'][0])) $response['value_price'] = $array['value_price'][0];
if (!empty($array['youtube-video'][0])) $response['youtube-video'] = 'https://www.youtube.com/watch?v='.$array['youtube-video'][0];

//ADD TO XML?
if (!empty($array['yandex'][0])) $response['yandex'] = $array['yandex'][0];
if (!empty($array['avito'][0])) $response['avito'] = $array['avito'][0];
if (!empty($array['cian'][0])) $response['cian'] = $array['cian'][0];

if (!empty($array['commercial-type'][0])) $response['commercial-type'] = $array['commercial-type'][0];
if (!empty($array['housetype'][0])) $response['housetype'] = $array['housetype'][0];
if (!empty($array['wallstype'][0])) $response['wallstype'] = $array['wallstype'][0];
if (!empty($array['propertyrights'][0])) $response['propertyrights'] = $array['propertyrights'][0];
if (!empty($array['houseobjecttype'][0])) $response['houseobjecttype'] = $array['houseobjecttype'][0];
if (!empty($array['landobjecttype'][0])) $response['landobjecttype'] = $array['landobjecttype'][0];

///NOVOSTROIKI
if (!empty($array['market_type'][0])) $response['market_type'] = $array['market_type'][0];
if (!empty($array['building-name'][0])) $response['building-name'] = $array['building-name'][0];
if (!empty($array['deal-status'][0])) $response['deal-status'] = $array['deal-status'][0];
if (!empty($array['building-state'][0])) $response['building-state'] = $array['building-state'][0];
if (!empty($array['built-year'][0])) $response['built-year'] = $array['built-year'][0];
if (!empty($array['ready-quarter'][0])) $response['ready-quarter'] = $array['ready-quarter'][0];

if (!empty($array['avitonewdev'][0])) $response['avitonewdev'] = $array['avitonewdev'][0];
if (!empty($array['yandexnewdev'][0])) $response['yandexnewdev'] = $array['yandexnewdev'][0];
if (!empty($array['ciannewdev'][0])) $response['ciannewdev'] = $array['ciannewdev'][0];
if (!empty($array['avitokorpus'][0])) $response['avitokorpus'] = $array['avitokorpus'][0];
if (!empty($array['yandexkorpus'][0])) $response['yandexkorpus'] = $array['yandexkorpus'][0];
if (!empty($array['ciankorpus'][0])) $response['ciankorpus'] = $array['ciankorpus'][0];
if (!empty($array['avitoid'][0])) $response['avitoid'] = $array['avitoid'][0];

if (!empty($array['metro_spb'][0])) $response['metro_spb'] = $array['metro_spb'][0];
if (!empty($array['metro_msk'][0])) $response['metro_msk'] = $array['metro_msk'][0];

if (!empty($array['address_2'][0])) $response['address_2'] = $array['address_2'][0];
if (!empty($array['address1'][0])) $response['address1'] = $array['address1'][0];

if (!empty($dtype)){
	$response['dealtype'] = $dtype;
}

if (!empty($ptype)) {
	$response['propertytype'] = $ptype;
}

return $response;

}

//ACF OPTIONS GET FIELD CHOICES

function get_field_choices($field_name, $multi = false) {
  $results = array();
  foreach (get_posts(array('post_type' => 'acf-field', 'posts_per_page' => -1)) as $acf) {
    if ($acf->post_excerpt === $field_name) {
      $field = unserialize($acf->post_content);
      if(isset($field['choices'])) {
        if(!$multi) return $field['choices'];
        else $results []= $field;
      }
    }
  }
  return $results;
}

?>
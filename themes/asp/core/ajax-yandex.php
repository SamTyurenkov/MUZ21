<?php

function getYandexStats() {

$data = array();
$errors = array();
$diff = '';
$weektime = date('Y-m-d\TH:i:s', strtotime('-6 days'));

$yandexdata = maybe_unserialize( get_post_meta( $post->ID, 'yandexdata',  true ));
$yandexerrors = maybe_unserialize(get_post_meta( $post->ID, 'yandexerrors',  true ));
$yandexexpiry = get_post_meta( $post->ID, 'yandexexpiry',  true );
$yandexid = get_post_meta( $post->ID, 'yandexid',  true );
if(empty($yandexexpiry)) $yandexexpiry = 1;

$urloffers = 'https://api.realty.yandex.net/2.0/crm/offers/?internalId='.$post->ID;
//CHECK IF CURL EXISTS

//USE CURL TO GET ACTIVE OFFERS
if (curlCheck() && ($yandex != 2) && check_expire($yandexexpiry) ) {
//echo 'connect';
$offers = curl_init($urloffers);
curl_setopt($offers, CURLOPT_HTTPHEADER, array('Authorization: OAuth AgAAAAAVbZJ7AAVccVqKnGAOWUSNhEsiPE6tpY8','X-Authorization: Vertis crm-dff153a8ef1a90d3bff5ee378dee416606cf8915') );
curl_setopt($offers, CURLOPT_FRESH_CONNECT, true);
curl_setopt($offers, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($offers, CURLOPT_RETURNTRANSFER, true);
$jsonoffers = curl_exec($offers);
$httpoffers = curl_getinfo($offers, CURLINFO_HTTP_CODE);
if(curl_errno($offers) == 0 AND $httpoffers == 200) {
//echo 'gotresp';
    $dataoffers = json_decode($jsonoffers, true);
	//	print_r( $dataoffers);
	foreach( $dataoffers['listing']['snippets'] as $offer) {

    foreach ($offer as $offerdata) {
		//print_r($offerdata);
		if (array_key_exists('errors', $offerdata['state'])) {
		$errors = $offerdata['state']['errors'];
		update_post_meta( $post->ID, 'yandexexpiry', time() );
		update_post_meta( $post->ID, 'yandexerrors', maybe_serialize($errors) );
		break 2;
		} else if ($offerdata['internalId'] == $post->ID) {
		$yandexid = $offerdata['id'];
		$url = 'https://api.realty.yandex.net/2.0/crm/offer/'.$yandexid.'/stats?startTime='.$weektime;
		update_post_meta( $post->ID, 'yandexid', $yandexid );
		$errors = 1;
		break 2;
		}
	}
	
	
	}
}
curl_close($offers);
} else if ($yandex != 2) {
	$errors = $yandexerrors;
	$data = $yandexdata;
}
//USE CURL TO GET JSON
if (curlCheck() && !empty($url) && ($yandex != 2)) {
$cs = curl_init($url);
curl_setopt($cs, CURLOPT_HTTPHEADER, array('Authorization: OAuth AgAAAAAVbZJ7AAVccVqKnGAOWUSNhEsiPE6tpY8','X-Authorization: Vertis crm-dff153a8ef1a90d3bff5ee378dee416606cf8915') );
curl_setopt($cs, CURLOPT_FRESH_CONNECT, true);
curl_setopt($cs, CURLOPT_CONNECTTIMEOUT, 15);
curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($cs);
$http = curl_getinfo($cs, CURLINFO_HTTP_CODE);
if(curl_errno($cs) == 0 AND $http == 200) {
    $data = json_decode($json, true);
	update_post_meta( $post->ID, 'yandexexpiry', time() );
	update_post_meta( $post->ID, 'yandexdata', maybe_serialize($data) );
	$errors = 1;
}
curl_close($cs);
}

return;
}

function yandexApiShow() {
if (!empty($data) && ($yandex != 2)) {

usort($data['stats']['daily'], function($a, $b) { 
     if ($a == $b) {
        return 0;
    }
    return ($b < $a) ? -1 : 1;
}); 

foreach ($data['stats']['daily'] as $info) {
$day = $info['day'];
$shows = $info['shows'];
$cardShows = $info['cardShows'];
$calls = $info['calls'];
{ ?>
<div class="day">
<li><?=$day;?></li>
<li>Показов: <?=$shows;?></li>
<li>Просмотров: <?=$cardShows;?></li>
<li>Звонков: <?=$calls;?></li>
</div>
<?php }}} else if (!empty($errors) && ($errors != 1) && ($yandex != 2)) {
foreach ($errors as $error) { ?>
<div class="day">
<li><b>Ошибка в данных</b></li>
<li><?=$error['type'];?></li>
</div>
<?php } ?>
<div class="day">
<li><b>Платные опции недоступны</b></li>
<li>Исправьте ошибки и подождите пока данные в Яндексе обновятся.</li>
<li>Обновление информации может занять до 24 часов.</li>
</div>
<?php } else { ?>
<div class="day">
<li><b>Нет информации от Яндекса</b></li>
<li>Либо объявление еще не опубликовано</li>
<li>Либо оно не подходит для публикации</li>
</div>
<div class="day">
<li><b>Платные опции недоступны</b></li>
<li>Убедитесь, что заполнили объявление подробно и правильно.</li>
<li>Обновление информации может занять до 24 часов.</li>
</div>
<?php }}; ?>

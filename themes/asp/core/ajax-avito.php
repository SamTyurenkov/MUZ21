<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function avitoApiShow() {
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
<li>Описание ошибки по <a target="_blank" href="https://yandex.ru/support/realty/requirements/errors.html">ссылке</a></li>
</div>
<?php } ?>
<div class="day">
<li><b>Платные опции недоступны</b></li>
<li>Исправьте ошибки и подождите пока данные в Авито обновятся.</li>
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
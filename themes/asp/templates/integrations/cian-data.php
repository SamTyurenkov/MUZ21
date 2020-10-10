<?php $cian = get_post_meta( $post->ID, 'cian',  true ); 
$xmlhash = get_the_author_meta( 'xmlhash', get_current_user_id() );
?>

<h3 class="homeh3 opendd">Выгрузка в Циан</h3>

<div class="dropdown">
<div class="editmenu">
<?php if ($cian == 1) { ?>
<span id="xmlcian" class="pslidercount" onClick="update_post_integrations(2,'cian')">Убрать из выгрузки</span>
<!--<span class="pslidercount" onClick="update_post_yandex(3)" id="yandexpromote">Продвинуть - 200 рублей</span>-->
<?php } else { ?>
<span id="xmlcian" class="pslidercount" onClick="update_post_integrations(1,'cian')">Добавить в выгрузку</span>
<?php } ?>
</div>

<div class="integration container">
<div class="custom-input">
<p>Ссылка на файл выгрузки</p>
<input type="text" readonly value="https://asp.sale/feed/cian-<?php echo esc_attr(get_current_user_id()); ?>?xkey=<?php echo esc_attr($xmlhash); ?>">
</div>

<div class="custom-input newdev" id="ciannewdev">
<p>ID Новостройки в Циан</p>
<input type="number" value="">
</div>

<div class="custom-input newdev" id="ciankorpus">
<p>ID Корпуса в Циан</p>
<input type="number" value="">
</div>

<div class="custom-widget">
<p>Полезная информация</p>
<a href="https://hc.cian.ru/hc/ru/articles/360020862771-%D0%9F%D1%80%D0%B0%D0%B2%D0%B8%D0%BB%D0%B0-%D0%B0%D0%B2%D1%82%D0%BE%D0%BC%D0%B0%D1%82%D0%B8%D1%87%D0%B5%D1%81%D0%BA%D0%BE%D0%B9-%D0%B2%D1%8B%D0%B3%D1%80%D1%83%D0%B7%D0%BA%D0%B8-%D0%BD%D0%B0-%D0%A6%D0%B8%D0%B0%D0%BD">Как добавить файл в Циан</a>
<a href="https://www.cian.ru/nd/validator/">Проверка файла на ошибки</a>
</div>

</div>
</div>
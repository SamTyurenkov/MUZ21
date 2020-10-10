<?php $yandex = get_post_meta( $post->ID, 'yandex',  true ); 
$xmlhash = get_the_author_meta( 'xmlhash', get_current_user_id() );
?>

<h3 class="homeh3 opendd opendd_open">Выгрузка в Яндекс</h3>

<div class="dropdown ddopen">
<div class="editmenu">
<?php if ($yandex == 1) { ?>
<span id="xmlyandex" class="pslidercount" onClick="update_post_integrations(2,'yandex')">Убрать из выгрузки</span>
<?php } else { ?>
<span id="xmlyandex" class="pslidercount" onClick="update_post_integrations(1,'yandex')">Добавить в выгрузку</span>
<?php } ?>
</div>

<div class="integration container">
<div class="custom-input">
<p>Ссылка на файл выгрузки</p>
<input type="text" readonly value="https://asp.sale/feed/yandex-<?php echo esc_attr(get_current_user_id()); ?>?xkey=<?php echo esc_attr($xmlhash); ?>">
</div>

<div class="custom-input newdev" id="yandexnewdev">
<p>ID Новостройки в Яндексе</p>
<input type="number" value="">
</div>

<div class="custom-input newdev" id="yandexkorpus">
<p>ID Корпуса в Яндексе</p>
<input type="number" value="">
</div>

<div class="custom-widget">
<p>Полезная информация</p>
<a href="https://yandex.ru/support/realty/agency/home/account-xml-partners-housing.html">Как добавить файл в Яндекс</a>
<a href="https://webmaster.yandex.ru/tools/xml-validator/">Проверка файла на ошибки</a>
<a href="https://yandex.ru/support/realty/requirements/errors.html">Описание кодов ошибок</a>
<a href="https://realty.yandex.ru/newbuildings.tsv">ID Новостроек Яндекса</a>
</div>

</div>

<div class="yandex container">
<?php 
//yandexApiShow(); 
?>

</div>

</div>



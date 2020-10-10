<?php $avito = get_post_meta( $post->ID, 'avito',  true ); 
$xmlhash = get_the_author_meta( 'xmlhash', get_current_user_id() );
?>

<h3 class="homeh3 opendd">Выгрузка в Авито</h3>

<div class="dropdown">
<div class="editmenu">
<?php if ($avito == 1) { ?>
<span id="xmlavito" class="pslidercount" onClick="update_post_integrations(2,'avito')">Убрать из выгрузки</span>
<?php } else { ?>
<span id="xmlavito" class="pslidercount" onClick="update_post_integrations(1,'avito')">Добавить в выгрузку</span>
<?php } ?>
</div>

<div class="integration container">
<div class="custom-input">
<p>Ссылка на файл выгрузки</p>
<input type="text" readonly value="https://asp.sale/feed/avito-<?php echo esc_attr(get_current_user_id()); ?>?xkey=<?php echo esc_attr($xmlhash); ?>">
</div>

<div class="custom-input" id="avitoid">
<p>ID Объявления на Avito</p>
<input type="number" value="">
<p>Укажите, если этот объект был размещен на Avito вручную.</p>
</div>

<div class="custom-input newdev" id="avitonewdev">
<p>ID Новостройки на Avito</p>
<input type="number" value="">
</div>

<div class="custom-input newdev" id="avitokorpus">
<p>ID Корпуса на Avito</p>
<input type="number" value="">
</div>

<div class="custom-widget">
<p>Полезная информация</p>
<a href="https://autoload.avito.ru/format/">Как добавить файл в Авито</a>
<a href="https://autoload.avito.ru/format/xmlcheck/">Проверка файла на ошибки</a>
<a href="https://autoload.avito.ru/format/faq/">Частые вопросы и ответы</a>
<a href="https://autoload.avito.ru/format/New_developments.xml">ID Новостроек Avito</a>
</div>

</div>

<div class="avito container">

</div>

</div>
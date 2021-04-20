<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php 
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
$curuser = wp_get_current_user();

$editors = explode(',', get_the_author_meta('editors', $curuser->ID));
array_push($editors, $curuser->ID);
$editors = array_filter(array_unique($editors)); 
?>

<div class="row" >
<h2 class="homeh2" id="title">Объявления пользователя</h2>
<p style="flex:0 0 100%;text-align:center">Используйте фильтры и кнопки, чтобы найти <?php if  ($curuser->ID == $curauth->ID) : ?>неопубликованные <?php endif; ?> объявления и статьи.</p>
<div class="textblockcontrols">

<div class="pslidercount" id="props" onclick="showProps()">
<i class="icon-building" style="color: #d03030"></i> Объявления
</div>

<div class="pslidercount" id="posts" onclick="showPosts()">
<i class="icon-doc-text" style="color: #d03030"></i> Посты
</div>

<?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) { ?>
<div class="pslidercount" onclick="showIntegrations()">
<i class="icon-cog"></i> <span>Выгрузки</span>
</div>
<?php } ?>

</div>
<div class="selector container" id="filters">

<div class="custom-select" id="querycity">
<select>
  <option value="empty">Город</option>
  <?php
foreach (CityManager::getCities() as $slug => $city) {
	echo '<option value="'.$city.'">'.$city.'</option>';
}
?>
</select>
</div>
<div class="custom-select" id="querytype">
<select>
  <option value="empty" selected="selected">Тип недвижимости</option>
  <option value="kvartira">Квартира</option>
  <option value="dom">Дом</option>
  <option value="komnata">Комната</option>
  <option value="nezhiloe">Нежилое</option>
  <option value="uchastok">Участок</option>
  <option value="hotel">Отель</option>
  <option value="novostrojka">Новостройка</option>
  <option value="koikomesto">Койко-место</option>
</select>
</div>
<div class="custom-select" id="querysort">
<select>
  <option value="empty" selected="selected">Сортировка</option>
  <option value="date">Новые</option>
  <option value="price">По цене</option>
</select>
</div>
<div class="custom-select" id="querydeal">
<select>
  <option value="empty">Тип сделки</option>
  <option value="kupit">Купить</option>
  <option value="snyat">Снять</option>
  <option value="posutochno-snyat">Снять посуточно</option>
</select>
</div>
<?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator') || in_array($curuser->ID, $editors)) { ?>
<div class="custom-select" id="querystatus">
<select>
  <option value="all" selected>Статус</option>
  <option value="publish">Опубликовано</option>
  <option value="draft">Снято с публикации</option>
  <option value="pending">На модерации</option>
</select>
</div>
<?php } ?>
</div>
<?php if ($curuser->ID == $curauth->ID || current_user_can('editor' || 'administrator')) { 
$xmlhash = get_the_author_meta( 'xmlhash', $curauth->ID );
?>
<div class="integration container" id="integration" style="display:none">
<div class="custom-input">
<p>Выгрузка в Яндекс</p>
<input type="text" readonly value="https://asp.sale/feed/yandex-<?php echo esc_attr($curauth->ID); ?>?xkey=<?php echo esc_attr($xmlhash); ?>">
<p>Выгрузка в Авито</p>
<input type="text" readonly value="https://asp.sale/feed/avito-<?php echo esc_attr($curauth->ID); ?>?xkey=<?php echo esc_attr($xmlhash); ?>">
<p>Выгрузка в Циан</p>
<input type="text" readonly value="https://asp.sale/feed/cian-<?php echo esc_attr($curauth->ID); ?>?xkey=<?php echo esc_attr($xmlhash); ?>">
</div>
<div class="custom-input">
<p>Добавьте объявления других пользователей в ваши выгрузки, указав ID пользователей через запятую.</p>
<input class="text managers" type="text" value="<?php echo esc_attr(get_the_author_meta( 'managers', $curauth->ID )); ?>" placeholder="Менеджеры">
<p>Добавьте редакторов, которые смогут редактировать ваши объявления, указав через запятую ID пользователей.</p>
<input class="text editors" type="text" value="<?php echo esc_attr(get_the_author_meta( 'editors', $curauth->ID )); ?>" placeholder="Редакторы">
</div>
</div>
<?php } ?>
</div>

<div class="categories2 container">
      
</div>
<div class="button loadprops"><i class="icon-plus"></i> Загрузить еще</div>
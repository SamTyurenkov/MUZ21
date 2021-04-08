<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$title = get_the_title($post); 
$text = get_the_content($post);
$category = get_the_category($post)[0];
$city = get_post_meta($post->ID,'locality-name',true);

$array = array(
	'array' => array(
		'category' => $category->slug,
		'locality-name' => $city,
	)
  );
wp_localize_script('asp-main','populatemeta',$array);//json_encode($options));
?>
<div class="selector container">

<div class="custom-select" id="category">
<p>Выберите тип контента</p>
<select>
  <option value="empty">Выберите</option>
  <option value="blog">Статья</option>
  <option value="news">Новость</option>
</select>
</div>

<div class="custom-select" id="locality-name">
<p>Выберите город (необязательно)</p>
<select>
  <option value="empty">Город</option>
  <option value="Сочи">Сочи</option>
  <option value="Москва">Москва</option>
  <option value="Санкт-Петербург">Санкт-Петербург</option>
  <option value="Тольятти">Тольятти</option>
  <option value="Псков">Псков</option>
  <option value="Оренбург">Оренбург</option>
</select>
</div>

<div class="custom-input" id="tags">
<p>Укажите теги, через запятую</p>
<input type="text" value="<?php $taglist = get_the_tags(); if ($taglist) {foreach($taglist as $tag){ echo esc_attr($tag->name).',';}} ?>">
</div>

</div>

<div class="textor container">

<h3 class="homeh3">Редактор текстовых блоков</h3>
<div class="custom-input" id="title">
<p>Заголовок статьи или новости</p>
<input type="text" class="h" value="<?php echo esc_attr(get_the_title()); ?>">
</div>
<div class="compositecontent">

</div>
<div class="textblockcontrols" id="addblock">

<?php if (current_user_can('administrator')) { ?>
<div class="pslidercount" id="addheader2" onclick="addBlockElement(this)">
<i class="icon-header">2</i> Заголовок
</div>
<?php } ?>

<div class="pslidercount" id="addheader3" onclick="addBlockElement(this)">
<i class="icon-header">3</i> Заголовок
</div>

<?php if (current_user_can('administrator')) { ?>
<div class="pslidercount" id="addheader4" onclick="addBlockElement(this)">
<i class="icon-header">4</i> Заголовок
</div>
<?php } ?>

<div class="pslidercount" id="addtext" onclick="addBlockElement(this)">
<i class="icon-paragraph"></i> Абзац
</div>
<div class="pslidercount" id="addlist" onclick="addBlockElement(this)">
<i class="icon-list-bullet"></i> Список
</div>
<div class="pslidercount" id="addphoto" onclick="addBlockElement(this)">
<i class="icon-picture"></i> Фото
</div>
</div>
<div class="textblockcontrols">

<div class="pslidercount" onclick="saveBlockEditor()">
<i class="icon-lock-open-alt"></i> <span class="error">Сохранить</span>
</div>
<?php if(current_user_can('administrator') == true) { ?>
<div class="pslidercount" onclick="synonimizer()">
<i class="icon-doc-text"></i> <span class="error">Рерайт</span>
</div>
<?php } ?>
</div>
</div>

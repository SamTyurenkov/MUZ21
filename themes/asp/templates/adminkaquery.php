<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div class="textblockcontrols" style="margin-top:55px">

<div class="pslidercount" id="props" onclick="showProps()">
<i class="icon-building" style="color: #d03030"></i> Объявления
</div>

<div class="pslidercount" id="posts" onclick="showPosts()">
<i class="icon-doc-text" style="color: #d03030"></i> Посты
</div>

<div class="pslidercount" id="newsletter" onclick="showLetters()">
<i class="icon-doc-text" style="color: #d03030"></i> Рассылки
</div>

</div>

<div class="row">
<h2 class="homeh2" id="title">Объявления</h2>
<div class="selector container" id="filters">

<div class="custom-select" id="querycity">
<select>
  <option value="empty">Город</option>
  <option value="Сочи">Сочи</option>
  <option value="Москва">Москва</option>
  <option value="Санкт-Петербург">Санкт-Петербург</option>
  <option value="Тольятти">Тольятти</option>
  <option value="Псков">Псков</option>
  <option value="Оренбург">Оренбург</option>
  <option value="Пенза">Пенза</option>
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
<div class="custom-select" id="querystatus">
<select>
  <option value="empty">Статус</option>
  <option value="publish">Опубликовано</option>
  <option value="draft">Снято с публикации</option>
  <option value="pending">На модерации</option>
</select>
</div>
</div>
</div>


<div class="categories2 container">
      
</div>
<div class="button loadprops"><i class="icon-plus"></i> Загрузить еще</div>
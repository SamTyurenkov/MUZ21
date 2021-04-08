<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$options = get_property_options($post);
$array = array(
  'array' => $options
);
wp_localize_script('asp-main','populatemeta',$array);//json_encode($options));

$title = get_the_title($post); 
$text = get_the_content($post);
$authid = get_the_author_meta( 'ID' );
?>
<div class="selector container">

<div class="custom-select" id="dealtype">
<p>Выберите тип сделки с объектом</p>
<select>
  <option value="empty">Тип сделки</option>
  <option value="kupit">Продать</option>
  <option value="snyat">Сдать</option>
  <option value="posutochno-snyat">Сдать Посуточно</option>
</select>
</div>

<div class="custom-select" id="propertytype">
<p>Выберите тип объекта недвижимости</p>
<select>
  <option value="empty">Тип недвижимости</option>
  <option value="kvartira">Квартира</option>
  <option value="dom">Дом</option>
  <option value="komnata">Комната</option>
  <option value="nezhiloe">Нежилое</option>
  <option value="uchastok">Участок</option>
  <option value="hotel">Номер в отеле</option>
<!--  <option value="novostrojka">Новостройка</option> -->
  <option value="koikomesto">Койко-место</option>
</select>
</div>

<div class="custom-select" id="locality-name">
<p>Город расположения объекта</p>
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

<?php if($options['locality-name'] == 'Санкт-Петербург' || $options['locality-name'] == 'Москва') { 
if($options['locality-name'] == 'Санкт-Петербург')
	$metrofield = 'metro_spb';
if($options['locality-name'] == 'Москва')
	$metrofield = 'metro_msk';
?>
<div class="custom-select" id="<?php echo esc_attr($metrofield);?>">
<p>Ближайшее метро</p>
<select>
<option value="empty">Метро</option>
<?php 

$choices = get_field_choices($metrofield);

foreach( $choices as $k => $v )
{
            echo '<option value="' . $k . '">' . $v . '</option>';
}


?>  
</select>
</div>

<?php }; ?>

<div class="custom-input" id="value_price">
<p>Стоимость объекта в рублях</p>
<input type="number" value="">
</div>

<div class="custom-input" id="value_area">
<p>Площадь объекта в метрах</p>
<input type="number" step="0.1" value="">
</div>

<div class="custom-input houseonly" id="lot_area">
<p>Площадь участка в сотках</p>
<input type="number" step="0.1" value="">
</div>

</div>
<h3 class="homeh3">Дополнительные опции</h3>
<div class="selector container">

<div class="custom-input" id="sublocality-name">
<p>Населенный пункт в городе</p>
<input type="text" value="">
</div>

<div class="custom-input" id="address_2">
<p>Улица/переулок</p>
<input type="text" value="">
</div>

<div class="custom-input" id="address1">
<p>Номер дома</p>
<input type="text" value="">
</div>

<div class="custom-input notland notroom" id="rooms">
<p>Количество комнат</p>
<input type="number" min="1" max="6" value="">
</div>

<div class="custom-input nothouse notland" id="floor">
<p>Этаж объекта</p>
<input type="number" min="-5" max="30" value="">
</div>

<div class="custom-input notland" id="floors_total">
<p>Всего этажей</p>
<input type="number" min="-5" max="30" value="">
</div>

<div class="custom-input notsale" id="krovatis">
<p>Количество спальных мест</p>
<input type="number" min="0" max="30" value="">
</div>

<div class="custom-input notsale dailyonly" id="min_stay">
<p>Минимальный срок аренды (суток)</p>
<input type="number" value="">
</div>

<div class="custom-input notsale" id="zalog">
<p>Размер залога в рублях</p>
<input type="number" value="">
</div>

<div class="custom-input notsale" id="agent-fee">
<p>Размер комиссии в рублях</p>
<input type="number" value="">
</div>

<div class="custom-select notland nothouse" id="market_type">
<p>Тип рынка</p>
<select>
  <option value="empty">Выберите</option>
  <option value="Вторичка">Вторичка</option>
  <option value="Новостройка">Новостройка</option>
</select>
</div>

<div class="custom-select nothouse notland" id="housetype">
<p>Тип дома</p>
<select>
  <option value="empty">Выберите</option>
  <option value="Кирпичный">Кирпичный</option>
  <option value="Панельный">Панельный</option>
  <option value="Блочный">Блочный</option>
  <option value="Монолитный">Монолитный</option>
  <option value="Деревянный">Деревянный</option>
</select>
</div>

<div class="custom-select houseonly" id="houseobjecttype">
<p>Тип здания</p>
<select>
  <option value="empty">Выберите</option>
  <option value="Дом">Дом</option>
  <option value="Дача">Дача</option>
  <option value="Коттедж">Коттедж</option>
  <option value="Таунхаус">Таунхаус</option>
</select>
</div>

<div class="custom-select houseonly" id="wallstype">
<p>Тип стен</p>
<select>
  <option value="empty">Выберите</option>
  <option value="Кирпич">Кирпич</option>
  <option value="Брус">Брус</option>
  <option value="Бревно">Бревно</option>
  <option value="Газоблоки">Газоблоки</option>
  <option value="Металл">Металл</option>
  <option value="Пеноблоки">Пеноблоки</option>
  <option value="Сэндвич-панели">Сэндвич-панели</option>
  <option value="Ж/б панели">Ж/б панели</option>
  <option value="Экспериментальные материалы">Экспериментальные материалы</option>
</select>
</div>

<div class="custom-select landonly" id="landobjecttype">
<p>Тип участка</p>
<select>
  <option value="empty">Выберите</option>
  <option value="Поселений (ИЖС)">Поселений (ИЖС)</option>
  <option value="Сельхозназначения (СНТ, ДНП)">Сельхозназначения (СНТ, ДНП)</option>
  <option value="Промназначения">Промназначения</option>
</select>
</div>

<div class="custom-select notlive" id="commercial-type">
<p>Выберите тип коммерческого помещения</p>
<select>
  <option value="empty">Тип помещения</option>
  <option value="auto repair">Автосервис</option>
  <option value="business">Готовый бизнес</option>
  <option value="free purpose">Свободное назначение</option>
  <option value="hotel">Отель</option>
  <option value="land">Коммерческая земля</option>
  <option value="legal address">Юр. Адрес</option>
  <option value="manufacturing">Производственное</option>
  <option value="office">Офисное</option>
  <option value="public catering">Общепит</option>
  <option value="retail">Торговое</option>
  <option value="warehouse">Склад</option>
</select>
</div>

<div class="custom-select" id="online-show">
<p>Онлайн показ объекта</p>
<select>
  <option value="empty">Выберите</option>
  <option value="Могу показать">Могу показать</option>
  <option value="Не хочу">Не хочу</option>
</select>
</div>

<div class="custom-input" id="youtube-video">
<p>Ссылка на Youtube-видео</p>
<input type="text" value="">
</div>

<div class="custom-select notsale" id="kommun-platezh">
<p>Коммунальные платежи</p>
<select>
  <option value="empty">Выберите</option>
  <option value="включены">включены</option>
  <option value="не включены">не включены</option>
</select>
</div>

<div class="custom-select notland" id="internet">
<p>Наличие доступа в интернет</p>
<select>
  <option value="empty">Выберите</option>
  <option value="Интернет за доп.плату">Интернет за доп.плату</option>
  <option value="Интернет бесплатно">Интернет бесплатно</option>
  <option value="Интернета нет">Интернета нет</option>
</select>
</div>

<div class="custom-select notland" id="television">
<p>Наличие ТВ</p>
<select>
  <option value="empty">Выберите</option>
  <option value="Кабельное ТВ">Кабельное ТВ</option>
  <option value="Обычное ТВ">Обычное ТВ</option>
  <option value="Телевизора нет">Телевизора нет</option>
</select>
</div>

<h3 class="homeh3 newdev">Опции для новостроек</h3>

<div class="custom-input newdev" id="building-name">
<p>Название ЖК</p>
<input type="text" value="">
</div>

<div class="custom-select newdev" id="deal-status">
<p>Тип сделки</p>
<select>
<option value="empty">Выберите</option>
<option value="Первичная продажа">Первичная продажа</option>
<option value="Переуступка">Переуступка</option>
</select>
</div>

<div class="custom-select newdev" id="building-state">
<p>Статус строительства</p>
<select>
<option value="empty">Выберите</option>
<option value="Построен, но не сдан">Построен, но не сдан</option>
<option value="Сдан">Сдан</option>
<option value="Строится">Строится</option>
</select>
</div>

<div class="custom-input newdev" id="built-year">
<p>Год сдачи</p>
<input type="number" value="" min="2013" max="2100">
</div>

<div class="custom-select newdev" id="ready-quarter">
<p>Квартал сдачи</p>
<select>
<option value="empty">Выберите</option>
<option value="1">1</option>
<option value="1">2</option>
<option value="1">3</option>
<option value="1">4</option>
</select>
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

<div class="pslidercount" id="addheader" onclick="addBlockElement(this)">
<i class="icon-header"></i> Заголовок
</div>
<div class="pslidercount" id="addtext" onclick="addBlockElement(this)">
<i class="icon-paragraph"></i> Абзац
</div>
<div class="pslidercount" id="addlist" onclick="addBlockElement(this)">
<i class="icon-list-bullet"></i> Список
</div>
</div>
<div class="textblockcontrols">

<div class="pslidercount" onclick="saveBlockEditor()">
<i class="icon-lock-open-alt"></i> <span class="error">Сохранить</span>
</div>
</div>
</div>
<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
wp_nonce_field('_add_properties', '_add_properties');
$curuser = wp_get_current_user();
?>
<div class="container">
<div class="editmenu">
<span class="pslidercount" onClick="addprop(1)">Объявления</span><span class="pslidercount" onClick="addprop(2)">Статьи</span><span class="pslidercount" onClick="closeaddproperty()">Закрыть</span>
</div>
</div>
<div id="addprop1">
<h3 class="homeh3" style="margin-top:70px">Добавить Объявление</h3>
<?php 

$pendprops = array( 'post_type'=>'property', 'post_status' => 'pending', 'author' => $curuser->ID);

$pendpp = new WP_Query( $pendprops );
$countpp = $pendpp->post_count;

if($countpp > 3) { ?>

<div class="selector container">
		<form class="add-form" action="valisend" method="post" style="max-width:100%;width:600px;padding-top:60px;text-align:center;margin:0 auto">
        	<div>
            <p>У вас уже есть <?= $countpp; ?> незавершенных черновиков Объявлений.</p>
			<p>Сначала завершите их и дождитесь публикации имеющихся, прежде чем создавать новые.</p>
			<div onClick="loadauth(1,'#props')" class="button">Посмотреть черновики Объявлений</div>
			<div id="validation" style="padding: 20px;color: #d03030"></div>
        </div>
        </form>
</div>

<?php 
wp_reset_postdata();
} else { ?>
<div class="selector container">

<div class="custom-select" id="adddealtype">
<p>Выберите тип сделки с объектом</p>
<select>
  <option value="empty">Тип сделки</option>
  <option value="kupit">Продать</option>
  <option value="snyat">Сдать</option>
  <option value="posutochno-snyat">Сдать Посуточно</option>
</select>
</div>

<div class="custom-select" id="addpropertytype">
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

<div class="custom-select" id="addlocality-name">
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

<div class="custom-input" id="addvalue_price">
<p>Стоимость объекта в рублях</p>
<input type="number" value="">
</div>

<div class="custom-input" id="addvalue_area">
<p>Площадь объекта в метрах</p>
<input type="number" value="">
</div>

<p>
После создания объявления, не забудьте добавить фотографии, а также указать дополнительные параметры. 
<br>
Постарайтесь указать как можно больше деталей, это поможет быстрее совершить сделку. 
</p>
</div>
<?php } ?>
<?php if($countpp < 5) { ?>
<div class="textblockcontrols" >

<div class="pslidercount" onclick="addProperty()">
Продолжить
</div>

</div>
<?php } ?>
</div>

<div id="addprop2" style="display:none">
<h3 class="homeh3" style="margin-top:70px">Добавить Новость/Статью</h3>
<?php 

$pendposts = array( 'post_type'=>'post', 'post_status' => 'pending', 'author' => $curuser->ID);

$pendp = new WP_Query( $pendposts );
$countp = $pendp->post_count;


if($countp > 3) { ?>

<div class="selector container">
		<form class="add-form" action="valisend" method="post" style="max-width:100%;width:600px;padding-top:60px;text-align:center;margin:0 auto">
        	<div>
            <p>У вас уже есть <?= $countp; ?> незавершенных черновиков Новостей/Статей.</p>
			<p>Сначала завершите их и дождитесь публикации имеющихся, прежде чем создавать новые.</p>
			<div onClick="loadauth(1,'#blog')" class="button">Посмотреть черновики Новостей</div>
			<div id="validation" style="padding: 20px;color: #d03030"></div>
        </div>
        </form>
</div>

<?php 
wp_reset_postdata();
} else { ?>
<div class="selector container">
<p>
Напишите новость или статью для сайта, на тему недвижимости или туризма.
</p>
<p>
Те, кто будут вас читать - могут стать вашими потенциальными клиентами.
</p>
<h3 class="homeh3">Несколько общих правил:</h3>
<ul>
<li>
Для новостей - обязателен новостной и аналитический характер. Не должны содержаться сообщения неновостного характера (прогнозы погоды, списки и расписания, сообщения блогов и форумов, анонсы предстоящих событий, реклама, стихи, анекдоты, фельетоны, гороскопы, художественные произведения и т. п.).
<br><b> В статьях от этого правила можно отступить.</b>
</li>
<li>
Тексты не должны содержать сведений рекламного характера. Не предлагайте прямо свои услуги в тексте новости или статьи.
</li>
<li>
Заголовки и тексты новостей и статей не должны вводить читателей в заблуждение, в том числе относительно содержания текстов, авторства текстов, источника информации и т. п.
</li>
</ul>
</div>
<?php } ?>
<?php if($countp < 5) { ?>
<div class="textblockcontrols" >

<div class="pslidercount" onclick="addBlog()">
Написать
</div>

</div>
<?php } ?>
</div>
<div class="adderror container">

</div>
<script type="text/javascript">
function addprop(n) {
var addprop1 = document.getElementById("addprop1");
var addprop2 = document.getElementById("addprop2");
if(n == 1) {
addprop1.style.display = 'block';
addprop2.style.display = 'none'
} else {
addprop2.style.display = 'block';
addprop1.style.display = 'none'
}
};

function addBlog() {

var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
var nonce = document.getElementById('_add_properties').value;
var id = parseInt('<?php echo esc_html($curuser->ID); ?>');

var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				nonce : nonce,
				id : id,
				action: 'add_blog_ajax',
				},
				success: function(data, textStatus, jqXHR) {
				if( data.response == "success" ){
				console.log(data.id);
				location.href = "https://asp.sale/?preview=true&post_type=post&p="+data.id;
				} else if (data.response == "error") {
					console.log(data.details);
					document.querySelector('.adderror').innerHTML = data.details;
				}
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					console.log('ajax error in add blog');
				}
			})

};


function addProperty() {

var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
var nonce = document.getElementById('_add_properties').value;
var id = parseInt('<?php echo esc_html($curuser->ID); ?>');
var meta = [];

var inputs = document.querySelectorAll('.addproperty .custom-select select, .addproperty .custom-input input');
for (var i = 0; i < inputs.length; i++) {
	meta[i] = inputs[i].value; 
}

var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				nonce : nonce,
				id : id,
				meta: meta,
				action: 'add_props_ajax',
				},
				success: function(data, textStatus, jqXHR) {
				if( data.response == "success" ){
				console.log(data.id);
				location.href = "https://asp.sale/?preview=true&post_type=property&p="+data.id;
				} else if (data.response == "error") {
					console.log(data.details);
					document.querySelector('.adderror').innerHTML = data.details;
				}
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					console.log('ajax error in add property');
				}
			})

};

</script>
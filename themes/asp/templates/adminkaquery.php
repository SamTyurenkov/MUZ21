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

<?php wp_nonce_field('_load_properties', '_load_properties'); ?>
<div class="categories2 container">
      
</div>
<div class="button loadprops"><i class="icon-plus"></i> Загрузить еще</div>
<script type="text/javascript">

var x, i, j, selElmnt, a, b, c;
/* Look for any elements with the class "custom-select": */
x = document.getElementsByClassName("custom-select");
for (i = 0; i < x.length; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  /* For each element, create a new DIV that will act as the selected item: */
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /* For each element, create a new DIV that will contain the option list: */
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < selElmnt.length; j++) {
    /* For each option in the original select element,
    create a new DIV that will act as an option item: */
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /* When an item is clicked, update the original select box,
        and the selected item: */
        var y, i, k, s, h;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        h = this.parentNode.previousSibling;
        for (i = 0; i < s.length; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            for (k = 0; k < y.length; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
    /* When the select box is clicked, close any other select boxes,
    and open/close the current select box: */
    e.stopPropagation();
    closeAllSelect(this);
    this.nextSibling.classList.toggle("select-hide");
    this.classList.toggle("select-arrow-active");
  });
}

function closeAllSelect(elmnt) {
  /* A function that will close all select boxes in the document,
  except the current select box: */
  var x, y, i, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  for (i = 0; i < y.length; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < x.length; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}

/* If the user clicks anywhere outside the select box,
then close all select boxes: */
document.addEventListener("click", closeAllSelect);
</script>
<script type="text/javascript">
var page = 1;
var posttype = 1;
var selectors = document.querySelectorAll("#filters .custom-select select");

function resetquery() {
page = 1;
document.querySelector('.categories2').innerHTML = '';
document.querySelector('.loadprops').innerHTML = '<i class="icon-plus"></i> Загрузить еще';
loadproperties();
}

function loadproperties() {

var selected = [];
if (selectors) {
for (var i = 0; i < selectors.length; i++) {
selected[i] = selectors[i].value;
}};

var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var nonce = document.getElementById('_load_properties').value;
var value = jQuery.ajax({
				type: 'GET',
				url: ajaxurl,
				data:{
				nonce : nonce,
				page : page,
				authid: '0',
				options : selected,
				action: 'auth_post_ajax',
				posttype: posttype,
				},
				success: function(data, textStatus, jqXHR) {
					page++;
					document.querySelector('.categories2').innerHTML += data["response"];
					if(data.amount < 9) {
					document.querySelector('.loadprops').innerHTML = 'Больше ничего нет';	
					}
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					console.log('ajax error in author query');
				}
			})
};

document.querySelector('.loadprops').addEventListener('click', function() {
	loadproperties();
}, false);

var dropdowns = document.querySelectorAll('#filters .select-items div');
for (var n = 0; n < dropdowns.length; n++) {
dropdowns[n].addEventListener('click', function() {
	resetquery();
}, false);
}

loadproperties();

function showPosts() {
document.querySelector('#querycity').style.display='block';
document.querySelector('#querystatus').style.display='block';
document.querySelector('#querytype').style.display='none';
document.querySelector('#querysort').style.display='none';
document.querySelector('#querydeal').style.display='none';
document.querySelector('#title').innerHTML='Новости и статьи';
posttype = 2;
resetquery();
};
function showProps() {
document.querySelector('#querycity').style.display='block';
document.querySelector('#querystatus').style.display='block';
document.querySelector('#querytype').style.display='block';
document.querySelector('#querysort').style.display='block';
document.querySelector('#querydeal').style.display='block';
document.querySelector('#title').innerHTML='Объявления';
posttype = 1;
resetquery();
};
function showLetters() {
document.querySelector('#querycity').style.display='none';
document.querySelector('#querystatus').style.display='none';
document.querySelector('#querytype').style.display='none';
document.querySelector('#querysort').style.display='none';
document.querySelector('#querydeal').style.display='none';
document.querySelector('#title').innerHTML='Объявления';
posttype = 3;
resetquery();
};
</script>
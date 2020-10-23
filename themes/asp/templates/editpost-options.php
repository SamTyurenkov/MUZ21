<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$options = get_property_options($post);
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
  <option value="Могу провести">Могу провести</option>
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

<script type="text/javascript">
function populate_meta_fields() {
	var dboptions = <?php echo json_encode($options); ?>;
	
	for (var i in dboptions) {
    if (dboptions.hasOwnProperty(i) && typeof(i) !== 'function') {
	try {
	var hasOption = document.getElementById(i).children[1].querySelector('option[value="' + dboptions[i] + '"]');
	if (hasOption || document.getElementById(i).children[1].tagName == 'INPUT')
	document.getElementById(i).children[1].value = dboptions[i];
		}
	catch(e) {
	console.log(e);		
		}
    }
	}

}
populate_meta_fields();
</script>

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
function addBlockElement(type) {
var composite = document.getElementsByClassName('compositecontent')[0];

if (type.id == 'addheader') {
	
		var custominput = document.createElement('div');
		createControls(custominput);
		
		let label = document.createElement("p");
		label.innerHTML = "Второстепенный заголовок";
		custominput.appendChild(label);
		
        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = 'Заголовок, который нужно отредактировать';
            textarea.className = "h";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');

    } else if (type.id == 'addtext') {
		
		var custominput = document.createElement('div');
		createControls(custominput);
		
		let label = document.createElement("p");
		label.innerHTML = "Блок текста";
		custominput.appendChild(label);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = 'Абзац, который нужно отредактировать';
            textarea.className = "p";
			textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');

    } else if (type.id == 'addlist') {
		
		var custominput = document.createElement('div');
		createControls(custominput);
		
		let label = document.createElement("p");
		label.innerHTML = "Элемент списка";
		custominput.appendChild(label);
		
		let visualli = document.createElement("div");
		visualli.className = 'visualli';
		visualli.innerHTML = "<li></li>";
		custominput.appendChild(visualli);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = 'Элемент списка, который нужно отредактировать';
            textarea.className = "li";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');
		
	}
}

function saveBlockEditor() {
var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
var nonce = document.getElementById('_edit_properties').value;
var id = parseInt('<?php echo $post->ID; ?>');
var composite = document.getElementsByClassName('compositecontent')[0];
var el = composite.children;
var content = '';

for (let i = 0; i < el.length; i++) {
var textarea = el[i].getElementsByTagName('textarea')[0];	
if(textarea.className == "p") {
content += '<p>';
content += textarea.value.replace(/(<|>)+/gm, "");
content += '</p>';
} else if (textarea.className == "h") {
content += '<h3>';
content += textarea.value.replace(/(<|>)+/gm, "");
content += '</h3>';
} else if (textarea.className == "li") {
content += '<li>';
content += textarea.value.replace(/(<|>)+/gm, "");
content += '</li>';
}

}
var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				nonce : nonce,
				id : id,
				content : content,
				action: 'update_props_content_ajax',
				},
				success: function(data, textStatus, jqXHR) {
					document.querySelector(".error").innerHTML = 'Информация сохранена';
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					document.querySelector(".error").innerHTML = 'Произошла ошибка';
				}
			})
}	

function createBlockEditor() {
var composite = document.getElementsByClassName('compositecontent')[0];
var newcomposite = document.createElement('newcomposite');
newcomposite.innerHTML = document.getElementsByClassName('entry-content')[0].innerHTML;
var el = newcomposite.children;

for (let i = 0; i < el.length; i++) {
if (["H2","H3","H4","H5","H6","DIV","P","UL","LI"].indexOf(el[i].tagName.toUpperCase()) == -1) continue;
	
	if (["H2","H3","H4","H5","H6"].indexOf(el[i].tagName.toUpperCase()) != -1) {
		var custominput = document.createElement('div');
		var text = el[i].textContent;
		createControls(custominput);
		
		let label = document.createElement("p");
		label.innerHTML = "Второстепенный заголовок";
		custominput.appendChild(label);
		
        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = text;
            textarea.className = "h";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');

    } else if (["P","DIV"].indexOf(el[i].tagName.toUpperCase()) != -1) {
		var custominput = document.createElement('div');
		var text = el[i].textContent;
		createControls(custominput);
		let label = document.createElement("p");
		label.innerHTML = "Блок текста";
		custominput.appendChild(label);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = text;
            textarea.className = "p";
			textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');

    } else if (["UL"].indexOf(el[i].tagName.toUpperCase()) != -1) {
		
		var li = el[i].children;
		
		for (let x = 0; x < li.length; x++) {
		var custominput = document.createElement('div');
		var text = li[x].textContent;
		createControls(custominput);
		
		let label = document.createElement("p");
		label.innerHTML = "Элемент списка";
		custominput.appendChild(label);
		
		let visualli = document.createElement("div");
		visualli.className = 'visualli';
		visualli.innerHTML = "<li></li>";
		custominput.appendChild(visualli);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = text;
            textarea.className = "li";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');
		}
		
	} else if (["LI"].indexOf(el[i].tagName.toUpperCase()) != -1) {
		
		var custominput = document.createElement('div');
		var text = el[i].textContent;
		createControls(custominput);
		
		let label = document.createElement("p");
		label.innerHTML = "Элемент списка";
		custominput.appendChild(label);
		
		let visualli = document.createElement("div");
		visualli.className = 'visualli';
		visualli.innerHTML = "<li></li>";
		custominput.appendChild(visualli);

        // Create a textarea
            let textarea = document.createElement("textarea");
            textarea.innerHTML = text;
            textarea.className = "li";
            textarea.setAttribute('oninput','this.style.height = "";this.style.height = this.scrollHeight + "px"');
            custominput.appendChild(textarea);
			textarea.style.resize = 'none';
			textarea.style.height = "";
			textarea.style.height = textarea.scrollHeight + "px";
			textarea.setAttribute('onfocus','active(this)');
		
		
	}
}
}

function createControls(custominput) {
	
var composite = document.getElementsByClassName('compositecontent')[0];	
  custominput.className = "custom-input passive";
  composite.appendChild(custominput);
	
		let close = document.createElement("div");
		close.innerHTML = "X";
		close.className = "close blockcontrols";
		close.setAttribute('onclick','move(this)');
		custominput.appendChild(close);
		
		let up = document.createElement("div");
		up.innerHTML = "<";
		up.className = "up blockcontrols";
		up.setAttribute('onclick','move(this)');
		custominput.appendChild(up);
		
		let down = document.createElement("div");
		down.innerHTML = ">";
		down.className = "down blockcontrols";
		down.setAttribute('onclick','move(this)');
		custominput.appendChild(down);
}
function active(obj) {
	var el = document.getElementsByClassName('compositecontent')[0].children;	
	for (let i = 0; i < el.length; i++) {
			el[i].classList.add('passive');
	}
	obj.parentNode.classList.remove('passive');
	document.querySelector(".error").innerHTML = 'Сохранить';
}

function move(obj) {
	var parent = obj.parentNode;
	var cname = obj.classList[0];
	
	if (cname == 'up' && parent.previousSibling) {
		parent.parentNode.insertBefore(parent, parent.previousSibling);
	} else if (cname == 'down' && parent.nextSibling) {
		parent.parentNode.insertBefore(parent.nextSibling, parent);
	} else if (cname == 'close') {
		parent.parentNode.removeChild(parent);
	}
}

createBlockEditor();
</script>

<script type="text/javascript">

function hide_wrong_meta() {
var notsale = document.getElementsByClassName("notsale");
var dailyonly = document.getElementsByClassName("dailyonly");

var notland = document.getElementsByClassName("notland");
var nothouse = document.getElementsByClassName("nothouse");
var notroom = document.getElementsByClassName("notroom");
var notlive = document.getElementsByClassName("notlive");
var houseonly = document.getElementsByClassName("houseonly");
var landonly = document.getElementsByClassName("landonly");
var newdev = document.getElementsByClassName("newdev");

	if (document.querySelector("#dealtype select").value == "kupit") {
		for (var n = 0; n < notsale.length; n++) notsale[n].style.display = "none";
	} else {
	for (var n = 0; n < notsale.length; n++) notsale[n].style.display = "block";	
	}

	if(document.querySelector("#propertytype select").value == "uchastok") {
		for (var n = 0; n < notland.length; n++) notland[n].style.display = "none";
		} else {
		for (var n = 0; n < notland.length; n++) notland[n].style.display = "block";	
		}

	if(document.querySelector("#propertytype select").value == "dom") {
		for (var n = 0; n < nothouse.length; n++) nothouse[n].style.display = "none";
		} else if (document.querySelector("#propertytype select").value != "uchastok") {
		for (var n = 0; n < nothouse.length; n++) nothouse[n].style.display = "block";	
		}
		
	if(document.querySelector("#propertytype select").value == "nezhiloe") {
		for (var n = 0; n < notlive.length; n++) notlive[n].style.display = "block";
		} else if (document.querySelector("#propertytype select").value != "nezhiloe") {
		for (var n = 0; n < notlive.length; n++) notlive[n].style.display = "none";	
		}	
		
	if(document.querySelector("#propertytype select").value == "dom") {
		for (var n = 0; n < houseonly.length; n++) houseonly[n].style.display = "block";
		} else if (document.querySelector("#propertytype select").value != "dom") {
		for (var n = 0; n < houseonly.length; n++) houseonly[n].style.display = "none";	
		}

//not room 
	if(document.querySelector("#propertytype select").value == "komnata") {
		for (var n = 0; n < notroom.length; n++) notroom[n].style.display = "none";
		} else if (document.querySelector("#propertytype select").value != "dom") {
		for (var n = 0; n < notroom.length; n++) notroom[n].style.display = "block";	
		}	

//daily only
	if (document.querySelector("#dealtype select").value == "posutochno-snyat") {
		for (var n = 0; n < dailyonly.length; n++) dailyonly[n].style.display = "block";
	} else {
	for (var n = 0; n < dailyonly.length; n++) dailyonly[n].style.display = "none";	
	}
		
		if(document.querySelector("#propertytype select").value == "uchastok") {
		for (var n = 0; n < landonly.length; n++) landonly[n].style.display = "block";
		} else if (document.querySelector("#propertytype select").value != "uchastok") {
		for (var n = 0; n < landonly.length; n++) landonly[n].style.display = "none";	
		}		
		
	if(document.querySelector("#market_type select").value == 'Новостройка') {
	for (var n = 0; n < newdev.length; n++) newdev[n].style.display = "block";
	} else if(document.querySelector("#market_type select").value != 'Новостройка') {
	for (var n = 0; n < newdev.length; n++) newdev[n].style.display = "none";
	}		
}
	
	var el = document.querySelectorAll(".editoptions .select-items div");
	for (i = 0; i < el.length; i++) {
	el[i].addEventListener("click", function() {
	update_post_meta(this.parentNode.parentNode.getElementsByTagName("select")[0]);
	hide_wrong_meta();
	}, true);
	};

	var elm = document.querySelectorAll(".editoptions .custom-input input, .integration .custom-input input");
	for (j = 0; j < elm.length; j++) {
	elm[j].addEventListener("change", function() {
	update_post_meta(this);
	hide_wrong_meta();
	}, true);
	};

hide_wrong_meta();

function update_post_meta(obj) {

var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
var nonce = document.getElementById('_edit_properties').value;
var id = parseInt('<?php echo $post->ID; ?>');
var authid = parseInt('<?php echo $authid; ?>');
var metaname = obj.parentNode.id;
try {
var metavalue = obj.parentNode.getElementsByTagName("select")[0].value;
} catch(e) {
var metavalue = obj.parentNode.getElementsByTagName("input")[0].value;
}
if(metaname == '') return;

var value = jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				cache: false,
				data:{
				nonce : nonce,
				id : id,
				authid: authid,
				metaname : metaname,
				metavalue : metavalue,
				action: 'update_props_ajax',
				},
				success: function(data, textStatus, jqXHR) {
					if(data.response == 'success') {
					console.log("success "+data.meta + data.val);
					} else {
					console.log("error "+data.meta + data.val);
					}
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					console.log('ajax error in update props');
				}
			})

};
</script>
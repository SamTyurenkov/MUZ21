<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<?php 
$taxonomy = get_queried_object();
$singletitle = single_term_title('',false);
$cit = get_query_var( 'city' );
$ptype = get_query_var( 'ptype' );	
$brcms = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/"><span itemprop="name">ASP</span></a><meta itemprop="position" content="1" /></span>';
$brcms .= ' > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$taxonomy->slug.'/"><span itemprop="name">'.$singletitle.'</span></a><meta itemprop="position" content="2" /></span>';
$title = '';
$typetitle = 'Недвижимость';
if (!empty($ptype)) {
	
switch($ptype) {
case 'kvartira':
	$typetitle = 'Квартиру';
	break;
case 'dom':
	$typetitle = 'Дом';
	break;
case 'komnata':
	$typetitle = 'Комнату';
	break;
case 'koikomesto':
	$typetitle = 'Койко-место';
	break;
case 'nezhiloe':
	$typetitle = 'Нежилое Помещение';
	break;
case 'uchastok':
	$typetitle = 'Участок';
	break;
case 'hotel':
	$typetitle = 'Номер в Отеле';
	break;
case 'novostrojka':
	$typetitle = 'Квартиру в Новостройке';
	break;
default:
	$typetitle = 'Недвижимость';
	$brcms .= ' > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$taxonomy->slug.'/nedvizhimost/"><span itemprop="name">'.$typetitle.'</span></a><meta itemprop="position" content="3" /></span>';
	break;
}	
if($typetitle != 'Недвижимость')
$brcms .= ' > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$taxonomy->slug.'/'.$ptype.'/"><span itemprop="name">'.$typetitle.'</span></a><meta itemprop="position" content="3" /></span>';
}
if (!empty($cit)) {
if ($cit == 'sochi') $city = 'Сочи';
if ($cit == 'moskva') $city = 'Москва';
if ($cit == 'sankt-peterburg') $city = 'Санкт-Петербург';	
if ($cit == 'tolyatti') $city = 'Тольятти';	
if ($cit == 'pskov') $city = 'Псков';	
if ($cit == 'orenburg') $city = 'Оренбург';	
if ($cit == 'penza') $city = 'Пенза';
$title = $city.' - ';
$brcms .= ' > <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="/'.$taxonomy->slug.'/'.$ptype.'/'.$cit.'/"><span itemprop="name">'.$city.'</span></a><meta itemprop="position" content="4" /></span>';	
}
$title .= $singletitle.' '.$typetitle;
?>

<div class="row category">
<h1 class="homeh2"><?php 
echo esc_html($title); ?> </h1>

<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
<?php echo $brcms; ?>
</div>

<div class="container" style="text-align:center">
<?php 
if($ptype) {
$curterm = get_term_by( 'slug', $ptype, 'property-type' );
} else {
$curterm = $taxonomy;
}
echo term_description( $curterm );
?>
</div>

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

</div>
</div>
<script type="text/javascript">
function populate_query_fields() {
	var city = '<?php if (!empty($city)) echo esc_html($city); ?>';
	var ptype = '<?php if (!empty($ptype)) echo esc_html($ptype); ?>';
	
	if (ptype != '' && ptype != 'nedvizhimost') document.getElementById('querytype').getElementsByTagName("select")[0].value = ptype;
	if (city != '') document.getElementById('querycity').getElementsByTagName("select")[0].value = city;
}
populate_query_fields();
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

<?php 
wp_nonce_field('_load_properties', '_load_properties');
?>
<div class="categories2 container">
      
</div>
<div class="button loadprops"><i class="icon-plus"></i> Загрузить еще</div>
<script type="text/javascript">
var page = 1;
var selectors = document.querySelectorAll("#filters .custom-select select");

function resetquery() {
page = 1;
document.querySelector('.categories2').innerHTML = '';
document.querySelector('.loadprops').innerHTML = '<i class="icon-plus"></i> Загрузить еще';
loadproperties();
}

function canUseWebP() {
    var elem = document.createElement('canvas');

    if (!!(elem.getContext && elem.getContext('2d'))) {
        // was able or not to get WebP representation
        return elem.toDataURL('image/webp').indexOf('data:image/webp') == 0;
    }

    // very old browser like IE 8, canvas not supported
    return false;
}

function loadproperties() {

var selected = [];
if (selectors) {
for (var i = 0; i < selectors.length; i++) {
selected[i] = selectors[i].value;
}};

var taxid = parseInt('<?php echo $taxonomy->term_id; ?>');
var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
var nonce = document.getElementById('_load_properties').value;

var value = jQuery.ajax({
				type: 'GET',
				url: ajaxurl,
				data:{
				nonce : nonce,
				page : page,
				taxid : taxid,
				options : selected,
				action: 'cat_post_ajax',
				},
				success: function(data, textStatus, jqXHR) {
					page++;
					var addwebp = data["response"];
					if(canUseWebP() == true) {
					addwebp = addwebp.split(".png").join(".png.webp");
					addwebp = addwebp.split(".jpg").join(".jpg.webp");
					addwebp = addwebp.split(".jpeg").join(".jpeg.webp");
					}

					document.querySelector('.categories2').innerHTML += addwebp;
					if(data.amount < 9) {
					document.querySelector('.loadprops').innerHTML = 'Больше объявлений нет';	
					}
				},
				error: function(jqXHR, textStatus, errorThrown){ 	
					console.log('ajax error in category query');
				}
			})
};

document.querySelector('.loadprops').addEventListener('click', function() {
	loadproperties();
}, false);

var dropdowns = document.querySelectorAll('#filters .select-items div');
for (var n = 0; n < dropdowns.length; n++) {
dropdowns[n].addEventListener('click', function() {
	console.log('reset');
	resetquery();
}, false);
}

loadproperties();
</script>
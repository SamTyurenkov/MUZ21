<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}; 
global $post;
get_header();
?>
<div class="container">
<?php get_template_part('templates/topmenu'); ?>

</div>
<div class="account-keeper">
<span style="color: #d03058;font-weight: 600;font-size: 150px;display: block;letter-spacing: -20px">404</span>
<span>Страница не найдена, но вы можете выбрать другую!</span>
</div>
<div class="categories" style="margin:0 auto 150px">
<div class="catblock1">
<a href="/kupit/"><h3>Купить недвижимость</h3></a>
<div class="catlist">
<a href="/kupit/dom/"><i class="icon-home"></i>Купить дом</a>
<a href="/kupit/kvartira/"><i class="icon-building-filled"></i>Купить квартиру</a>
<a href="/kupit/uchastok/"><i class="icon-tree"></i>Купить участок</a>
<a href="/kupit/nezhiloe/"><i class="icon-rouble"></i>Для бизнеса</a>
</div>
</div>
<div class="catblock1">
<a href="/snyat/"><h3>Длительная аренда</h3></a>
<div class="catlist">
<a href="/snyat/dom/"><i class="icon-home"></i>Снять дом</a>
<a href="/snyat/kvartira/"><i class="icon-building-filled"></i>Снять квартиру</a>
<a href="/snyat/komnata/"><i class="icon-cube"></i>Снять комнату</a>
<a href="/snyat/nezhiloe/"><i class="icon-rouble"></i>Для бизнеса</a>
</div>
</div>
<div class="catblock1">
<a href="/posutochno-snyat/"><h3>Краткосрочная аренда</h3></a>
<div class="catlist">
<a href="/posutochno-snyat/dom/"><i class="icon-home"></i>Дома посуточно</a>
<a href="/posutochno-snyat/kvartira/"><i class="icon-building-filled"></i>Квартиры посуточно</a>
<a href="/posutochno-snyat/komnata/"><i class="icon-cube"></i>Комнаты посуточно</a>
<a href="/posutochno-snyat/koikomesto/"><i class="icon-bed"></i>Койко-места посуточно</a>
</div>
</div>
</div>
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

<?php get_footer(); ?>
</body>
</html>
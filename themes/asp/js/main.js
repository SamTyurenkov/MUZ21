"use strict";

var x, i, j, selElmnt, a, b, c;

for (x = document.getElementsByClassName("custom-select"), i = 0; i < x.length; i++) {
  for (selElmnt = x[i].getElementsByTagName("select")[0], (a = document.createElement("DIV")).setAttribute("class", "select-selected"), a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML, x[i].appendChild(a), (b = document.createElement("DIV")).setAttribute("class", "select-items select-hide"), j = 1; j < selElmnt.length; j++) {
    (c = document.createElement("DIV")).innerHTML = selElmnt.options[j].innerHTML, c.addEventListener("click", function (e) {
      var y, i, k, s, h;

      for (s = this.parentNode.parentNode.getElementsByTagName("select")[0], h = this.parentNode.previousSibling, i = 0; i < s.length; i++) {
        if (s.options[i].innerHTML == this.innerHTML) {
          for (s.selectedIndex = i, h.innerHTML = this.innerHTML, y = this.parentNode.getElementsByClassName("same-as-selected"), k = 0; k < y.length; k++) {
            y[k].removeAttribute("class");
          }

          this.setAttribute("class", "same-as-selected");
          break;
        }
      }

      h.click();
    }), b.appendChild(c);
  }

  x[i].appendChild(b), a.addEventListener("click", function (e) {
    e.stopPropagation(), closeAllSelect(this), this.nextSibling.classList.toggle("select-hide"), this.classList.toggle("select-arrow-active");
  });
}

function closeAllSelect(elmnt) {
  var x,
      y,
      i,
      arrNo = [];

  for (x = document.getElementsByClassName("select-items"), y = document.getElementsByClassName("select-selected"), i = 0; i < y.length; i++) {
    elmnt == y[i] ? arrNo.push(i) : y[i].classList.remove("select-arrow-active");
  }

  for (i = 0; i < x.length; i++) {
    arrNo.indexOf(i) && x[i].classList.add("select-hide");
  }
}

document.addEventListener("click", closeAllSelect), $ = jQuery, $(document).ready(function () {
  $(".opendd").click(function () {
    $(this).next().toggleClass("ddopen"), $(this).toggleClass("opendd_open");
  }), $(".splide").length && new Splide(".splide", {
    width: "100%",
    gap: "7px",
    lazyLoad: "nearby",
    autoWidth: !0,
    autoplay: !0,
    arrows: "slider",
    interval: 1800,
    pauseOnHover: !0,
    trimSpace: "move"
  }).mount();
}), $ = jQuery, $(document).ready(function () {
  var page = 1,
      selectors = document.querySelectorAll("#filters .custom-select select");

  function loadproperties() {
    if ("undefined" != typeof localize) {
      var action = localize.action,
          obj_id = parseInt(localize.obj_id),
          ajaxurl = localize.ajaxurl,
          nonce = localize.nonce,
          selected = [];
      if (selectors) for (var i = 0; i < selectors.length; i++) {
        selected[i] = selectors[i].value;
      }
      jQuery.ajax({
        type: "GET",
        url: ajaxurl,
        data: {
          nonce: nonce,
          page: page,
          obj_id: obj_id,
          options: selected,
          action: action,
          posttype: 1
        },
        success: function success(data, textStatus, jqXHR) {
          page++;
          var addwebp = data.response;
          1 == function canUseWebP() {
            var elem = document.createElement("canvas");
            return !(!elem.getContext || !elem.getContext("2d")) && 0 == elem.toDataURL("image/webp").indexOf("data:image/webp");
          }() && (addwebp = (addwebp = (addwebp = addwebp.split(".png").join(".png.webp")).split(".jpg").join(".jpg.webp")).split(".jpeg").join(".jpeg.webp")), document.querySelector(".categories2").innerHTML += addwebp, data.amount < 9 && (document.querySelector(".loadprops").innerHTML = "Больше объявлений нет");
        },
        error: function error(jqXHR, textStatus, errorThrown) {
          console.log("ajax error in query");
        }
      });
    }
  }

  $(".loadprops").on("click", function () {
    console.log("loadmore"), loadproperties();
  });

  for (var dropdowns = document.querySelectorAll("#filters .select-items div"), n = 0; n < dropdowns.length; n++) {
    dropdowns[n].addEventListener("click", function () {
      console.log("reset"), page = 1, document.querySelector(".categories2").innerHTML = "", document.querySelector(".loadprops").innerHTML = '<i class="icon-plus"></i> Загрузить еще', loadproperties();
    }, !1);
  }

  loadproperties();
}), function (m, e, t, r, i, k, a) {
  m.ym = m.ym || function () {
    (m.ym.a = m.ym.a || []).push(arguments);
  }, m.ym.l = 1 * new Date(), k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = "https://mc.yandex.ru/metrika/tag.js", a.parentNode.insertBefore(k, a);
}(window, document, "script"), ym(62533903, "init", {
  clickmap: !0,
  trackLinks: !0,
  accurateTrackBounce: !0,
  webvisor: !0
});
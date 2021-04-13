"use strict";

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var ErrorsManager = /*#__PURE__*/function () {
  function ErrorsManager() {
    _classCallCheck(this, ErrorsManager);
  }

  _createClass(ErrorsManager, null, [{
    key: "createEl",
    value: function createEl(type, message) {
      var el = document.createElement("div");
      el.classList.add("errors_el");
      var close = document.createElement("div");
      close.classList.add("errors_close");
      var content = document.createElement("div");
      content.classList.add("errors_content"), el.appendChild(close), el.appendChild(content), close.innerHTML = "X", close.setAttribute("onclick", "ErrorsManager.deleteEl(this)"), "error" == type ? (content.innerHTML = message, el.classList.add("errors_bad")) : "success" == type && (content.innerHTML = message, el.classList.add("errors_good")), document.getElementsByClassName("errors")[0].appendChild(el), setTimeout(function (close) {
        ErrorsManager.deleteEl(close);
      }, 1e4);
      var exers = document.querySelectorAll(".errors_close");
      (exers.length > 2 || window.innerWidth < 650 && exers.length > 1) && this.deleteEl(exers[0]);
    }
  }, {
    key: "deleteEl",
    value: function deleteEl(el) {
      void 0 !== el && null != el && el.parentNode.remove();
    }
  }]);

  return ErrorsManager;
}();

(function (m, e, t, r, i, k, a) {
  m[i] = m[i] || function () {
    (m[i].a = m[i].a || []).push(arguments);
  };

  m[i].l = 1 * new Date();
  k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a);
})(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

ym(62533903, "init", {
  clickmap: true,
  trackLinks: true,
  accurateTrackBounce: true,
  webvisor: true
});

function populate_meta_fields() {
  if (console.log("populate"), "undefined" != typeof populatemeta) {
    var dboptions = populatemeta.array;

    for (var i in console.log(populatemeta.array), dboptions) {
      if (dboptions.hasOwnProperty(i) && "function" != typeof i) try {
        (document.getElementById(i).children[1].querySelector('option[value="' + dboptions[i] + '"]') || "INPUT" == document.getElementById(i).children[1].tagName) && (document.getElementById(i).children[1].value = dboptions[i]);
      } catch (e) {
        console.log(e);
      }
    }
  }
}

var x, i, j, selElmnt, a, b, c;

for (populate_meta_fields(), x = document.getElementsByClassName("custom-select"), i = 0; i < x.length; i++) {
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

document.addEventListener("click", closeAllSelect);
$ = jQuery, $(document).ready(function () {
  $(".opendd").click(function () {
    $(this).next().toggleClass("ddopen"), $(this).toggleClass("opendd_open");
  }), $(".splide").length && new Splide(".splide", {
    width: "100%",
    gap: "7px",
    lazyLoad: "sequential",
    autoWidth: !0,
    autoplay: !0,
    arrows: "slider",
    interval: 1800,
    pauseOnHover: !0,
    trimSpace: "move"
  }).mount();
});
$ = jQuery;
var page = 1,
    posttype = 1,
    selectors = document.querySelectorAll("#filters .custom-select select");

function resetquery() {
  page = 1, document.querySelector(".categories2").innerHTML = "", document.querySelector(".loadprops").innerHTML = '<i class="icon-plus"></i> Загрузить еще', loadproperties();
}

function canUseWebP() {
  var elem = document.createElement("canvas");
  return !(!elem.getContext || !elem.getContext("2d")) && 0 == elem.toDataURL("image/webp").indexOf("data:image/webp");
}

function loadproperties() {
  if ("undefined" != typeof localize) {
    var action = localize.action,
        obj_id = parseInt(localize.obj_id),
        ajaxurl = localize.ajaxurl,
        selected = [];
    if (selectors) for (var i = 0; i < selectors.length; i++) {
      selected[i] = selectors[i].value;
    }
    jQuery.ajax({
      type: "GET",
      url: ajaxurl,
      data: {
        page: page,
        obj_id: obj_id,
        options: selected,
        action: action,
        posttype: posttype
      },
      success: function success(data, textStatus, jqXHR) {
        page++;
        var addwebp = data.response;
        1 == canUseWebP() && (addwebp = (addwebp = (addwebp = addwebp.split(".png").join(".png.webp")).split(".jpg").join(".jpg.webp")).split(".jpeg").join(".jpeg.webp")), document.querySelector(".categories2").innerHTML += addwebp, data.amount < 9 && (document.querySelector(".loadprops").innerHTML = "Больше объявлений нет");
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        console.log("ajax error in query");
      }
    });
  }
}

$(document).ready(function () {
  $(".loadprops").on("click", function () {
    console.log("loadmore"), loadproperties();
  });

  for (var dropdowns = document.querySelectorAll("#filters .select-items div"), n = 0; n < dropdowns.length; n++) {
    dropdowns[n].addEventListener("click", function () {
      console.log("reset"), resetquery();
    }, !1);
  }

  "#blog" === window.location.hash ? (document.querySelector("#querystatus select").value = "pending", showPosts()) : "#props" === window.location.hash ? (document.querySelector("#querystatus select").value = "pending", showProps()) : loadproperties();
});
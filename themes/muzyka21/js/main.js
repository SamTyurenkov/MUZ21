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
      (exers.length > 2 || window.innerWidth < 1651 && exers.length > 1) && this.deleteEl(exers[0]);
    }
  }, {
    key: "deleteEl",
    value: function deleteEl(el) {
      void 0 !== el && null != el && el.parentNode.remove();
    }
  }]);

  return ErrorsManager;
}();

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
  selElmnt = x[i].getElementsByTagName("select")[0], (a = document.createElement("DIV")).setAttribute("class", "select-selected"), a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML, x[i].appendChild(a), (b = document.createElement("DIV")).setAttribute("class", "select-items select-hide");
  var jj = 1;

  for ("undefined" == typeof populatemeta && (jj = 0), j = jj; j < selElmnt.length; j++) {
    (c = document.createElement("DIV")).innerHTML = selElmnt.options[j].innerHTML, c.addEventListener("click", function (e) {
      var y, i, k, s, h;

      for (s = this.parentNode.parentNode.getElementsByTagName("select")[0], h = this.parentNode.parentNode.getElementsByClassName("select-selected")[0], i = 0; i < s.length; i++) {
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
    if (e.stopPropagation(), closeAllSelect(this), this.nextSibling.classList.toggle("select-hide"), this.classList.toggle("select-arrow-active"), ["querycity", "addlocality-name", "locality-name"].includes(this.parentElement.id)) {
      var sels = this.parentElement.getElementsByClassName("select-selected");

      if (1 == sels.length) {
        var inp = document.createElement("input");
        inp.setAttribute("class", "select-selected"), inp.setAttribute("autocomplete", "chrome-off"), $(sels[0]).after(inp);
      }

      (sels = this.parentElement.getElementsByClassName("select-selected"))[0].style.display = "none", sels[1].style.display = "block", sels[1].focus(), sels[1].addEventListener("input", function (ee) {
        ee.stopPropagation();
        var txt = this.value;
        $(sels[1].nextSibling.childNodes).show(), $(sels[1].nextSibling.childNodes).each(function () {
          this.innerHTML.toLowerCase().includes(txt.toLowerCase()) || $(this).hide();
        });
      });
    }
  });
}

function closeAllSelect(elmnt) {
  var x,
      y,
      i,
      arrNo = [];

  for (x = document.getElementsByClassName("select-items"), y = document.getElementsByClassName("select-selected"), i = 0; i < y.length; i++) {
    elmnt == y[i] ? arrNo.push(i) : (y[i].classList.remove("select-arrow-active"), y[i].style.display = "block", $(".select-items div").show(), y[i].nextSibling.classList.contains("select-selected") && y[i].nextSibling.remove());
  }

  for (i = 0; i < x.length; i++) {
    arrNo.indexOf(i) && x[i].classList.add("select-hide");
  }
}

document.addEventListener("click", closeAllSelect);
$ = jQuery, $(document).ready(function () {
  $(".menu_button").on("click", function () {
    $(".menu_mobile").toggleClass("visible");
  }), $(".menu-item-has-children").on("mouseenter", function () {
    this.getElementsByClassName("sub-menu")[0].classList.add("active");
  }), $(".sub-menu").on("mouseleave", function () {
    this.classList.remove("active");
  }), $(".closeaccforms").on("click", function () {
    $(".account_forms").hide();
  }), $(".openaccforms").on("click", function (e) {
    e.preventDefault(), e.stopPropagation(), console.log(Number.isInteger(parseInt(localize.uid))), Number.isInteger(parseInt(localize.uid)) ? (location.href = window.location.protocol + "//" + window.location.hostname + "/author/" + localize.uname, console.log(window.location.protocol + "//" + window.location.hostname + "/author/" + localize.uname)) : $(".account_forms").css("display", "flex");
  });
});
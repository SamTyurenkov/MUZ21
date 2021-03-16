"use strict";

function showPosts() {
  document.querySelector(".categories2").style.display = "flex", document.querySelector("#filters").style.display = "flex", document.querySelector("#integration") && (document.querySelector("#integration").style.display = "none"), document.querySelector("#querytype").style.display = "none", document.querySelector("#querysort").style.display = "none", document.querySelector("#querydeal").style.display = "none", document.querySelector("#title").innerHTML = "Новости и статьи пользователя", posttype = 2, resetquery();
}

function showProps() {
  document.querySelector(".categories2").style.display = "flex", document.querySelector("#filters").style.display = "flex", document.querySelector("#integration") && (document.querySelector("#integration").style.display = "none"), document.querySelector("#querytype").style.display = "block", document.querySelector("#querysort").style.display = "block", document.querySelector("#querydeal").style.display = "block", document.querySelector("#title").innerHTML = "Объявления пользователя", posttype = 1, resetquery();
}

function showIntegrations() {
  document.querySelector(".categories2").style.display = "none", document.querySelector("#filters").style.display = "none", document.querySelector("#integration").style.display = "flex", document.querySelector("#querytype").style.display = "block", document.querySelector("#querysort").style.display = "block", document.querySelector("#querydeal").style.display = "block", document.querySelector("#title").innerHTML = "Выгрузки и настройки";
}

function showLetters() {
  document.querySelector("#querycity").style.display = "none", document.querySelector("#querystatus").style.display = "none", document.querySelector("#querytype").style.display = "none", document.querySelector("#querysort").style.display = "none", document.querySelector("#querydeal").style.display = "none", document.querySelector("#title").innerHTML = "Письма и рассылки", posttype = 3, resetquery();
}

var evt = document.createEvent("MouseEvents");
evt.initMouseEvent("click", !0, !0, window, 1, 0, 0, 0, 0, !1, !1, !1, !1, 0, null), "#blog" === window.location.hash ? (document.querySelector("#querystatus select").value = "pending", showPosts()) : "#props" === window.location.hash ? (document.querySelector("#querystatus select").value = "pending", showProps()) : loadproperties();
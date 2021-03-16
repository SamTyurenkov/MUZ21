function showPosts() {
  document.querySelector(".categories2").style.display = "flex";
  document.querySelector("#filters").style.display = "flex";
  if (document.querySelector("#integration"))
    document.querySelector("#integration").style.display = "none";

  document.querySelector("#querytype").style.display = "none";
  document.querySelector("#querysort").style.display = "none";
  document.querySelector("#querydeal").style.display = "none";
  document.querySelector("#title").innerHTML = "Новости и статьи пользователя";
  posttype = 2;
  resetquery();
}
function showProps() {
  document.querySelector(".categories2").style.display = "flex";
  document.querySelector("#filters").style.display = "flex";
  if (document.querySelector("#integration"))
    document.querySelector("#integration").style.display = "none";

  document.querySelector("#querytype").style.display = "block";
  document.querySelector("#querysort").style.display = "block";
  document.querySelector("#querydeal").style.display = "block";
  document.querySelector("#title").innerHTML = "Объявления пользователя";
  posttype = 1;
  resetquery();
}
function showIntegrations() {
  document.querySelector(".categories2").style.display = "none";
  document.querySelector("#filters").style.display = "none";
  document.querySelector("#integration").style.display = "flex";

  document.querySelector("#querytype").style.display = "block";
  document.querySelector("#querysort").style.display = "block";
  document.querySelector("#querydeal").style.display = "block";
  document.querySelector("#title").innerHTML = "Выгрузки и настройки";
}
function showLetters() {
  document.querySelector("#querycity").style.display = "none";
  document.querySelector("#querystatus").style.display = "none";
  document.querySelector("#querytype").style.display = "none";
  document.querySelector("#querysort").style.display = "none";
  document.querySelector("#querydeal").style.display = "none";
  document.querySelector("#title").innerHTML = "Письма и рассылки";
  posttype = 3;
  resetquery();
}

var evt = document.createEvent("MouseEvents");
evt.initMouseEvent(
  "click",
  true,
  true,
  window,
  1,
  0,
  0,
  0,
  0,
  false,
  false,
  false,
  false,
  0,
  null
);

if (window.location.hash === "#blog") {
  document.querySelector("#querystatus select").value = "pending";
  showPosts();
} else if (window.location.hash === "#props") {
  document.querySelector("#querystatus select").value = "pending";
  showProps();
} else {
  loadproperties();
}

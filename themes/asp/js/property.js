"use strict";

document.getElementById("callclick").addEventListener("click", function () {
  var cid = uuid(),
      time = new Date(Date.now()),
      ajaxurl = "https://www.google-analytics.com/collect?v=1&tid=UA-55186923-1&cid=" + cid + "&t=event&ec=click&ea=phonenumber&z=" + Math.floor(time.getTime() / 1e3).toString();
  jQuery.ajax({
    type: "POST",
    url: ajaxurl
  }, !0);
});
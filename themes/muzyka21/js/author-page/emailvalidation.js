"use strict";

$ = jQuery, $(document).ready(function () {
  document.getElementById("valisend").addEventListener("click", function (e) {
    e.preventDefault();
    var ajaxurl = localize.ajaxurl,
        id = localize.uid,
        nonce = document.getElementById("_vali_send").value;
    jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      cache: !1,
      data: {
        id: id,
        nonce: nonce,
        action: "valisend"
      },
      success: function success(data, textStatus, jqXHR) {
        console.log("val.success"), document.getElementById("valisend").style.pointerEvents = "none", document.getElementById("valisend").style.background = "#f2f2f2", document.getElementById("validation").innerHTML = "Письмо отправлено";
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        console.log("val.error"), document.getElementById("valisend").style.pointerEvents = "none", document.getElementById("valisend").style.background = "#f2f2f2", document.getElementById("validation").innerHTML = textStatus;
      }
    });
  }, !0);
});
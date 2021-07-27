$ = jQuery;
$(document).ready(function () {

  $(".createevent").on("click", function (e) { 
      e.preventDefault();

      var ajaxurl = localize.ajaxurl;
      var meta = document.getElementsByClassName("neweventname")[0].value;
      var nonce = document.getElementById("_editauthmeta").value;

      var value = jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        cache: false,
        data: {
          id: id,
          meta: meta,
          nonce: nonce,
          action: "creategame",
        },
        success: function (data, textStatus, jqXHR) {
          if (data.response == "SUCCESS") {
            ErrorsManager.createEl("success", "Черновик события создан");
            location.href = localize.homeurl + "?p=" + data.info;

          } else if (data.response == "ERROR") {
            ErrorsManager.createEl("error", "Ошибка: " + data.error);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          ErrorsManager.createEl("error", "Ошибка: " + textStatus);
        },
      });
    });
});

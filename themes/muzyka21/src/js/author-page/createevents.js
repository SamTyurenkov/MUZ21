$ = jQuery;
$(document).ready(function () {

  $(".createevent").on("click", function (e) { 
      e.preventDefault();

      var ajaxurl = localize_author.ajaxurl;
      var aid = localize_author.aid;
      var meta = document.getElementsByClassName("neweventname")[0].value;
      var nonce = document.getElementById("_editauthmeta").value;

      var value = jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        cache: false,
        data: {
          aid: aid,
          meta: meta,
          nonce: nonce,
          action: "createevent",
        },
        success: function (data, textStatus, jqXHR) {
          console.log(data);
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

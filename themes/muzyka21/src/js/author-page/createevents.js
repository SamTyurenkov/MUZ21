$ = jQuery;
$(document).ready(function () {

  $(".createevent").on("click", function (e) { 
      e.preventDefault();
      document.querySelector('.author_event').style = 'pointer-events:none;opacity:0.3';
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

          if (data.response == "SUCCESS") {

            ErrorsManager.createEl("success", "Черновик события создан");

            window.location.href = localize_author.homeurl + "?post_type=events&p=" + data.info;

          } else if (data.response == "ERROR") {
            ErrorsManager.createEl("error", "Ошибка: " + data.error);

          }
          document.querySelector('.author_event').style = '';
        },
        error: function (jqXHR, textStatus, errorThrown) {
          ErrorsManager.createEl("error", "Ошибка: " + textStatus);
          document.querySelector('.author_event').style = '';
        },
      });
    });
});

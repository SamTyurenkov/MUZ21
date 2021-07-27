$ = jQuery;
$(document).ready(function () {
  $(
    ".validateuseremail, .invalidateuseremail, .makeresident, .cancelresident"
  ).on("click", function (e) {
    e.preventDefault();
    var el = this;
    var ajaxurl = localize_admin_author.ajaxurl;
    var aid = localize_admin_author.aid;
    console.log(el.classList[1]);

    var value = jQuery.ajax({
      type: "POST",
      url: ajaxurl,
      cache: false,
      data: {
        aid: aid,
        action: el.classList[1],
      },
      success: function (data, textStatus, jqXHR) {
        el.style.pointerEvents = "none";
        ErrorsManager.createEl("success", "Пользователь обновлен");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        el.style.pointerEvents = "none";
        ErrorsManager.createEl("error", "Ошибка: " + textStatus);
      },
    });
  });
});

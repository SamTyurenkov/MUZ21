$ = jQuery;
$(document).ready(function () {

  $(".general-gallery_flex_el").on("click", function () {

    if ($(this).hasClass("active") == false) {
      $(".general-gallery_flex_el").removeClass("active");
      $(this).addClass("active");
    } else {
      $(".general-gallery_flex_el").removeClass("active");
    }
  });
});

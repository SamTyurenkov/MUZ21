$ = jQuery;
$(document).ready(function () {
  $(".opendd").click(function () {
    $(this).next().toggleClass("ddopen");
    $(this).toggleClass("opendd_open");
  });

  if ($(".splide").length) {
    new Splide(".splide", {
      width: "100%",
      gap: "7px",
      autoWidth: true,
      autoplay: true,
      arrows: 'slider',
      interval: 1800,
      pauseOnHover: true,
      trimSpace: "move",
    }).mount();
  }
});

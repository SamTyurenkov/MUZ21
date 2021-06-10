$ = jQuery;
$(document).ready(function () {

  if ($(".splide").length) {
    new Splide(".splide", {
      width: "100%",
      gap: "7px",
      lazyLoad: 'sequential',
      autoWidth: true,
      autoplay: true,
      arrows: 'slider',
      interval: 1800,
      pauseOnHover: true,
      trimSpace: "move",
    }).mount();
  }


});

$ = jQuery;
$(document).ready(function () {

console.log('muzevents');

if ($(".muzwavesevents").length) {
    new Splide(".muzwavesevents", {
      width: "100%",
      gap: "15px",
      lazyLoad: 'sequential',
      autoWidth: true,
      autoplay: false,
      arrows: false, //'slider',
      pagination: false,
      interval: 1800,
      pauseOnHover: true,
      trimSpace: "move",
    }).mount();
  }

});
 
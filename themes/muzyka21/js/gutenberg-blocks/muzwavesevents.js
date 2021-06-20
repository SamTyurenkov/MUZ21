"use strict";

$ = jQuery;
$(document).ready(function () {
  console.log('muzevents');

  if ($(".splide").length) {
    new Splide(".splide", {
      width: "100%",
      gap: "15px",
      lazyLoad: 'sequential',
      autoWidth: true,
      autoplay: false,
      arrows: false,
      //'slider',
      pagination: false,
      interval: 1800,
      pauseOnHover: true,
      trimSpace: "move"
    }).mount();
  }
});
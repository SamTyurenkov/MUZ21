"use strict";

$ = jQuery;
$(document).ready(function () {


  if ($(".event-price_flex_left").length) {
    new Splide(".event-price_flex_left", {
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
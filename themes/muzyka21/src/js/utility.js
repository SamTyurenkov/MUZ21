$ = jQuery;
$(document).ready(function () {

  var scrolltos = document.querySelectorAll('.scrollto');
  for (var j = 0; j < scrolltos.length; j++) {
    scrolltos[j].addEventListener('click',function(e){
      e.preventDefault();
    var target = this.getAttribute('data-target');
    $([document.documentElement, document.body]).animate({
          scrollTop: $(target).offset().top-70
      }, 700);
    });
  }	

  $('input').on('click', function(e){
    $(this).removeClass('input_invalid');
  })
  $('.menu_button').on('click', function () {
    $('.menu_mobile').toggleClass('visible');
  });

  $('.menu-item-has-children').on('mouseenter', function() {
    this.getElementsByClassName('sub-menu')[0].classList.add('active');
  });

  $('.sub-menu').on('mouseleave', function() {
    this.classList.remove('active');
  });

  $('.closeaccforms').on('click', function () {
    $('.account_forms').hide();
  });

  $('.openaccforms').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation();

    console.log(Number.isInteger(parseInt(localize.uid)));
    if(Number.isInteger(parseInt(localize.uid))) {
      location.href = window.location.protocol + '//' + window.location.hostname + '/author/' + localize.uname;
      console.log(window.location.protocol + '//' + window.location.hostname + '/author/' + localize.uname);
    } else {
      $('.account_forms').css('display','flex');
    }
  });

  
  anime.timeline({loop: false})
  .add({
    targets: 'h1, h2, h3',
    scale: [0.9, 1],
    duration: 2300,
    elasticity: 300,
    delay: (el, i) => 500 * i
  });

  anime.timeline({loop: true})
  .add({
    targets: '.shape, .shape3',
    scale: [1, 0.9, 1.2, 1],
    rotate: ['1turn','0turn'],
    duration: 20300,
    elasticity: 300,
    delay: (el, i) => 700
  });

  if ($(".audioplayer_inner").length) {
    new Splide(".audioplayer_inner", {
        type: 'loop',
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
        focus: 'center'
    }).mount();
}

});

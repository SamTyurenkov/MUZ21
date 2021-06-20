$ = jQuery;
$(document).ready(function () {

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

});

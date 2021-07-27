$ = jQuery;
$(document).ready(function () {

  document.querySelector('.usermenu_tabs_el').classList.add('active');
  document.querySelector('.usermenu_tabscontent_el').classList.add('active');

  $(".usermenu_tabs_el").on(
    "click",
    function (e) {
        $(".usermenu_tabs_el").removeClass('active');
        $(".usermenu_tabscontent_el").removeClass('active');
        
        $(this).addClass('active');
        var tabname = $(this).data('name');
        $(".usermenu_tabscontent").find(`[data-name='${tabname}']`).addClass('active');   

    });
});

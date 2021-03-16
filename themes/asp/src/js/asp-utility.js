$ = jQuery;
$( document ).ready(function() {

    $('.opendd').click( function() {
        $(this).next().toggleClass( 'ddopen' );
		$(this).toggleClass('opendd_open');
    });

    if(document.querySelector('.splide'))
    new Splide( '.splide' ).mount();
});
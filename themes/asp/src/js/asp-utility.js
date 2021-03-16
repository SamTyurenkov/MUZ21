$ = jQuery;
$( document ).ready(function() {

    $('.opendd').click( function() {
        $(this).next().toggleClass( 'ddopen' );
		$(this).toggleClass('opendd_open');
    });

    if(document.querySelector('.splide'))
    new Splide( '.splide', {
        autoWidth: true,
        autoplay: true,
        lazyLoad: 'sequential',
        breakpoints: {
            640: {
                arrows: false,
            },
        }
    } ).mount();
});
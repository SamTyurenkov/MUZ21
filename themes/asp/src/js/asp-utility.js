$ = jQuery;
$( document ).ready(function() {

    $('.opendd').click( function() {
        $(this).next().toggleClass( 'ddopen' );
		$(this).toggleClass('opendd_open');
    });

    if(document.querySelector('.splide'))
    new Splide( '.splide', {
        type: 'loop',
        width: '100%',
        gap: "7px",
        autoWidth: true,
        autoplay: true,
        arrows: true,
        interval: 800,
        pauseOnHover: true,
        trimSpace: 'move',
    } ).mount();
});
$ = jQuery;
$(document).ready(function () {
	if ($(".event-price_flex_left").length) {
		new Splide(".event-price_flex_left", {
			width: "100%",
			gap: "15px",
			lazyLoad: "sequential",
			autoWidth: true,
			autoplay: false,
			arrows: false,
			//'slider',
			pagination: false,
			interval: 1800,
			pauseOnHover: true,
			trimSpace: "move",
		}).mount();
	}

	$(document).on("click", ".event-price_flex_price_value", function () {
		$(".prepayment-frame").attr("data-id", $(this).parent().data("id"));
		$(".prepayment-frame .form_title").html($("h1").html() + " - " + $(this).parent().find("h4").html());
		$(".prepayment-frame .form_price").html("<b>" + $(this).parent().find(".button").html() + "</b>");
		$(".prepayment-frame").toggleClass("active");
	});
});

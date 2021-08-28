$ = jQuery;
$(document).ready(function () {
	$(".prepayment-frame").on("click", function (e) {
		$(this).toggleClass("active");
	});
	$(".prepayment-frame_customer_details").on("click", function (e) {
		e.stopPropagation();
		e.stopImmediatePropagation();
	});
	$(".closepayframe").on("click", function (e) {
		e.stopPropagation();
		e.stopImmediatePropagation();
		$(".prepayment-frame").toggleClass("active");
	});

	$('.prepayment-frame_customer_details input[type="submit"]').on("click", function (e) {
		if (!ValidateEmail($(".prepayment-frame_customer_details .form_email").val())) $(".prepayment-frame_customer_details .form_email").addClass("input_invalid");

		if ($(".prepayment-frame_customer_details .form_name").val().length < 1) $(".prepayment-frame_customer_details .form_name").addClass("input_invalid");

		if ($(".prepayment-frame_customer_details .form_phone").val().length < 1 || !ValidatePhone($(".prepayment-frame_customer_details .form_phone").val()))
			$(".prepayment-frame_customer_details .form_phone").addClass("input_invalid");

		$(this).css("pointer-events", "none").css("opacity", "0.3");

		var ajaxurl = localize_prepayment.ajaxurl;
		var nonce = $("#_payments").val();
		var username = $(".prepayment-frame_customer_details .form_name").val();
		var email = $(".prepayment-frame_customer_details .form_email").val();
		var phone = $(".prepayment-frame_customer_details .form_phone").val();
		var title = $(".prepayment-frame_customer_details .form_title").html();
		var price = $(".event-price_flex_price_value span").html();
		var type = localize_prepayment.type;
		var postid = localize_prepayment.postid;
		var optionid = $(".prepayment-frame_customer_details").data("id");

		var value = jQuery.ajax({
			url: ajaxurl,
			data: {
				username: username,
				nonce: nonce,
				email: email,
				phone: phone,
				title: title,
				price: price,
				postid: postid,
				optionid: optionid,
				yaclientID: document.querySelector('#yaCID').getAttribute('content'),
				type: type, 
				action: "prepayment",
			},
			type: "POST",
			dataType: "json",
			success: function (data, textStatus, jqXHR) {
				if (data.response == "SUCCESS") {
					$(".prepayment-frame_customer_details .order_id").html(data.info);
					ym(84234994, "reachGoal", "make-order");
					ErrorsManager.createEl("success", "Заказ успешно создан");
					$("#alfa-payment-button").attr('data-amount',price);
					$(".prepayment-frame").removeClass("active");
					$("#alfa-payment-button button").trigger( "click" );
				} else if (data.response == "ERROR") {
					ErrorsManager.createEl("error", "Ошибка: " + data.error);
				}
				$('.prepayment-frame_customer_details input[type="submit"]').css("pointer-events", "all").css("opacity", "1");
			},
			error: function (jqXHR, textStatus, errorThrown) {
				ErrorsManager.createEl("error", "Ошибка: " + errorThrown);
				$('.prepayment-frame_customer_details input[type="submit"]').css("pointer-events", "all").css("opacity", "1");
			},
		});
	});
});

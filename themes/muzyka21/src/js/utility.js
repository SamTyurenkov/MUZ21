function ValidateEmail(mail) {
	if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(mail)) {
		return true;
	}
	return false;
}

function ValidatePhone(phone) {
	if (/^\+[0-9]{11,15}$/.test(phone)) {
		return true;
	}
	return false;
}

$ = jQuery;
$(document).ready(function () {
	var scrolltos = document.querySelectorAll(".scrollto");
	for (var j = 0; j < scrolltos.length; j++) {
		scrolltos[j].addEventListener("click", function (e) {
			e.preventDefault();
			var target = this.getAttribute("data-target");
			$([document.documentElement, document.body]).animate(
				{
					scrollTop: $(target).offset().top - 70,
				},
				700
			);
		});
	}

	$("input").on("click", function (e) {
		$(this).removeClass("input_invalid");
	});
	$(".menu_button").on("click", function () {
		$(".menu_mobile").toggleClass("visible");
	});

	$(".menu-item-has-children").on("mouseenter", function () {
		this.getElementsByClassName("sub-menu")[0].classList.add("active");
	});

	$(".sub-menu").on("mouseleave", function () {
		this.classList.remove("active");
	});

	$(".closeaccforms").on("click", function () {
		$(".account_forms").hide();
	});

	$(".openaccforms").on("click", function (e) {
		e.preventDefault();
		e.stopPropagation();

		if (Number.isInteger(parseInt(localize.uid))) {
			location.href = localize.homeurl + "/author/" + localize.uname;
		} else {
			$(".account_forms").css("display", "flex");
		}
	});

	$(".menu-topbar-container .menu-item-has-children:after").on("click", function (e) {
		e.stopPropagation();
		e.preventDefault();
		$(this.parentNode.querySelector(".sub-menu")).toggleClass("active");
	});

	anime.timeline({ loop: false }).add({
		targets: "h1, h2, h3",
		scale: [0.9, 1],
		duration: 2300,
		elasticity: 300,
		delay: (el, i) => 500 * i,
	});

	anime.timeline({ loop: true }).add({
		targets: ".shape, .shape3",
		scale: [1, 0.9, 1.2, 1],
		rotate: ["1turn", "0turn"],
		duration: 20300,
		elasticity: 300,
		delay: (el, i) => 700,
	});

	if ($(".audioplayer_inner").length) {
		new Splide(".audioplayer_inner", {
			type: "loop",
			width: "100%",
			gap: "15px",
			lazyLoad: "sequential",
			autoWidth: true,
			autoplay: false,
			arrows: false, //'slider',
			pagination: false,
			interval: 1800,
			pauseOnHover: true,
			trimSpace: "move",
			focus: "center",
		}).mount();
	}

  if(document.querySelector('.usermenu_tabs_el')) {
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
  }
});

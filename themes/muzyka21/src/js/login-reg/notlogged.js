$ = jQuery;
$(document).ready(function () {

		var auth1 = document.querySelector("#auth1");
		var auth2 = document.querySelector("#auth2");
		var auth3 = document.querySelector("#auth3");
		var showreset = document.querySelector("#showreset");
		var showreg = document.querySelector("#showreg");
		var showlogin = document.querySelector("#showlogin");

		function sw1() {
			auth2.style.display = 'block';
			auth1.style.display = 'none';
		};

		function sw2() {
			auth1.style.display = 'block';
			auth2.style.display = 'none';
		};

		function sw3() {
			auth3.style.display = 'block';
		};
		showreset.addEventListener("click", function() {
			sw3();
		});
		showreg.addEventListener("click", function() {
			sw1();
		});
		showlogin.addEventListener("click", function() {
			sw2();
		})

		var logform = document.getElementById("logsubmit");
		var regform = document.getElementById("regsubmit");
		var recoveryform = document.getElementById("recoverylink");

		var loguser = document.getElementById("username");
		var logpass = document.getElementById("password");

		var regemail = document.getElementById("email");
		var regphone = document.getElementById("phone");
		var regpass = document.getElementById("signonpassword");
		var regpasscheck = document.getElementById("password2");

		var recovery = document.getElementById("recovery");

		regphone.addEventListener("input", function(e) {
			if (regphone.value.charAt(0) == '8') regphone.value = regphone.value.replace('8', '+7');
			regphone.value = regphone.value.replace(/[^0-9+]/, '');
		});

		//recovery
		recoveryform.addEventListener("click", function(e) {
			var ajaxurl = localize.ajaxurl;
			var nonce = document.getElementById("_regforms").value;
			var username = recovery.value;

			var value = jQuery.ajax({
				url: ajaxurl,
				data: {
					username: username,
					nonce: nonce,
					action: 'ajax_forgotpassword',
				},
				type: 'POST',
				dataType: 'json',
				success: function(data, textStatus, jqXHR) {

					console.log(data.response + data.message);
					recoveryform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
					recoveryform.parentElement.getElementsByClassName("status")[0].innerHTML = data.message;

				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
					recoveryform.parentElement.getElementsByClassName("status")[0].innerHTML = errorThrown;
				}
			});

		}, true);

		//login
		logform.addEventListener("click", function(e) {
			var ajaxurl = localize.ajaxurl;
			var nonce = document.getElementById("_regforms").value;
			var username = loguser.value;
			var password = logpass.value;

			var value = jQuery.ajax({
				url: ajaxurl,
				data: {
					password: password,
					username: username,
					nonce: nonce,
					action: 'ajax_login',
				},
				type: 'POST',
				dataType: 'json',
				success: function(data, textStatus, jqXHR) {

					console.log('data.response ' + data.response + ' ' + textStatus);
					logform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
					logform.parentElement.getElementsByClassName("status")[0].innerHTML = data.message;
					if (data.response == 'SUCCESS') {
						location.href = localize.homeurl + '/author/' + data.id; // window.location.protocol + '//' + window.location.hostname + '/author/' + data.id;
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
					logform.parentElement.getElementsByClassName("status")[0].innerHTML = errorThrown;
				}
			});

		}, true);

		//register
		regform.addEventListener("click", function(e) {
			regform.parentElement.getElementsByClassName("status")[0].style.display = 'none';

			var ajaxurl = localize.ajaxurl;
			var nonce = document.getElementById("_regforms").value;

			var email = regemail.value;
			var phone = regphone.value;
			var password = regpass.value;
			var password2 = regpasscheck.value;


			if (password != password2) {
				regpasscheck.style.borderColor = '#cd192e';
				regpass.style.borderColor = '#cd192e';
				regform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
				regform.parentElement.getElementsByClassName("status")[0].innerHTML = 'Пароли не совпадают';
			} else if (/^\+7[0-9]{10}$/.test(phone) == false) {
				regform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
				regform.parentElement.getElementsByClassName("status")[0].innerHTML = 'Укажите телефон в формате +79999999999';
			} else if (/.+@.+\.[a-zA-Z]+/.test(email) == false) {
				regform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
				regform.parentElement.getElementsByClassName("status")[0].innerHTML = 'Укажите почту в формате xxx@yyy.zzz';
			} else {
				var value = jQuery.ajax({
					url: ajaxurl,
					data: {
						password: password,
						email: email,
						phone: phone,
						nonce: nonce,
						action: 'ajax_register',
					},
					type: 'POST',
					dataType: 'json',
					success: function(data, textStatus, jqXHR) {
						console.log(data.message);
						regform.parentElement.getElementsByClassName("status")[0].style.display = 'block';
						regform.parentElement.getElementsByClassName("status")[0].innerHTML = data.message;
						if (data.response == 'SUCCESS') {
							ym(84234994,'reachGoal','registration');
							location.href = localize.homeurl + '/author/' + data.id; //window.location.protocol + '//' + window.location.hostname + '/author/' + data.id;
						}
					},
					error: function(jqXHR, textStatus, errorThrown) {
						console.log(errorThrown);
						regform.parentElement.getElementsByClassName("status")[0].innerHTML = errorThrown;
					}
				});
			}
		}, true);
	});
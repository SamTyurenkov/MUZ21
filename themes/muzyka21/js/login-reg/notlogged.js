"use strict";

$ = jQuery, $(document).ready(function () {
  var auth1 = document.querySelector("#auth1"),
      auth2 = document.querySelector("#auth2"),
      auth3 = document.querySelector("#auth3"),
      showreset = document.querySelector("#showreset"),
      showreg = document.querySelector("#showreg"),
      showlogin = document.querySelector("#showlogin");
  showreset.addEventListener("click", function () {
    !function sw3() {
      auth3.style.display = "block";
    }();
  }), showreg.addEventListener("click", function () {
    !function sw1() {
      auth2.style.display = "block", auth1.style.display = "none";
    }();
  }), showlogin.addEventListener("click", function () {
    !function sw2() {
      auth1.style.display = "block", auth2.style.display = "none";
    }();
  });
  var logform = document.getElementById("logsubmit"),
      regform = document.getElementById("regsubmit"),
      recoveryform = document.getElementById("recoverylink"),
      loguser = document.getElementById("username"),
      logpass = document.getElementById("password"),
      regemail = document.getElementById("email"),
      regphone = document.getElementById("phone"),
      regpass = document.getElementById("signonpassword"),
      regpasscheck = document.getElementById("password2"),
      recovery = document.getElementById("recovery");
  regphone.addEventListener("input", function (e) {
    "8" == regphone.value.charAt(0) && (regphone.value = regphone.value.replace("8", "+7")), regphone.value = regphone.value.replace(/[^0-9+]/, "");
  }), recoveryform.addEventListener("click", function (e) {
    var ajaxurl = localize.ajaxurl,
        nonce = document.getElementById("_regforms").value,
        username = recovery.value;
    jQuery.ajax({
      url: ajaxurl,
      data: {
        username: username,
        nonce: nonce,
        action: "ajax_forgotpassword"
      },
      type: "POST",
      dataType: "json",
      success: function success(data, textStatus, jqXHR) {
        console.log(data.response + data.message), recoveryform.parentElement.getElementsByClassName("status")[0].style.display = "block", recoveryform.parentElement.getElementsByClassName("status")[0].innerHTML = data.message;
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown), recoveryform.parentElement.getElementsByClassName("status")[0].innerHTML = errorThrown;
      }
    });
  }, !0), logform.addEventListener("click", function (e) {
    var ajaxurl = localize.ajaxurl,
        nonce = document.getElementById("_regforms").value,
        username = loguser.value,
        password = logpass.value;
    jQuery.ajax({
      url: ajaxurl,
      data: {
        password: password,
        username: username,
        nonce: nonce,
        action: "ajax_login"
      },
      type: "POST",
      dataType: "json",
      success: function success(data, textStatus, jqXHR) {
        console.log("data.response " + data.response + " " + textStatus), logform.parentElement.getElementsByClassName("status")[0].style.display = "block", logform.parentElement.getElementsByClassName("status")[0].innerHTML = data.message, "SUCCESS" == data.response && (location.href = localize.homeurl + "/author/" + data.id);
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown), logform.parentElement.getElementsByClassName("status")[0].innerHTML = errorThrown;
      }
    });
  }, !0), regform.addEventListener("click", function (e) {
    regform.parentElement.getElementsByClassName("status")[0].style.display = "none";
    var ajaxurl = localize.ajaxurl,
        nonce = document.getElementById("_regforms").value,
        email = regemail.value,
        phone = regphone.value,
        password = regpass.value;
    if (password != regpasscheck.value) regpasscheck.style.borderColor = "#cd192e", regpass.style.borderColor = "#cd192e", regform.parentElement.getElementsByClassName("status")[0].style.display = "block", regform.parentElement.getElementsByClassName("status")[0].innerHTML = "Пароли не совпадают";else if (0 == /^\+7[0-9]{10}$/.test(phone)) regform.parentElement.getElementsByClassName("status")[0].style.display = "block", regform.parentElement.getElementsByClassName("status")[0].innerHTML = "Укажите телефон в формате +79999999999";else if (0 == /.+@.+\.[a-zA-Z]+/.test(email)) regform.parentElement.getElementsByClassName("status")[0].style.display = "block", regform.parentElement.getElementsByClassName("status")[0].innerHTML = "Укажите почту в формате xxx@yyy.zzz";else jQuery.ajax({
      url: ajaxurl,
      data: {
        password: password,
        email: email,
        phone: phone,
        nonce: nonce,
        action: "ajax_register"
      },
      type: "POST",
      dataType: "json",
      success: function success(data, textStatus, jqXHR) {
        console.log(data.message), regform.parentElement.getElementsByClassName("status")[0].style.display = "block", regform.parentElement.getElementsByClassName("status")[0].innerHTML = data.message, "SUCCESS" == data.response && (location.href = localize.homeurl + "/author/" + data.id);
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown), regform.parentElement.getElementsByClassName("status")[0].innerHTML = errorThrown;
      }
    });
  }, !0);
});
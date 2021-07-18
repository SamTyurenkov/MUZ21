"use strict";

$ = jQuery;
$(document).ready(function () {
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

  $('.prepayment-frame_customer_details input[type="submit"]').on(
    "click",
    function (e) {
      if (
        !ValidateEmail(
          $(".prepayment-frame_customer_details .form_email").val()
        )
      )
        $(".prepayment-frame_customer_details .form_email").addClass(
          "input_invalid"
        );

      if ($(".prepayment-frame_customer_details .form_name").val().length < 1)
        $(".prepayment-frame_customer_details .form_name").addClass(
          "input_invalid"
        );

      if ($(".prepayment-frame_customer_details .form_phone").val().length < 1 ||!ValidatePhone($(".prepayment-frame_customer_details .form_phone").val()))
        $(".prepayment-frame_customer_details .form_phone").addClass(
          "input_invalid"
        );

      var ajaxurl = localize.ajaxurl;
      var nonce = $("#_payments").val();
      var username = $(".prepayment-frame_customer_details .form_name").val();
      var email = $(".prepayment-frame_customer_details .form_email").val();
      var phone = $(".prepayment-frame_customer_details .form_phone").val();
      var title = $(".prepayment-frame_customer_details .form_title").html();
      var postid = localize.postid;
      var optionid = $(".prepayment-frame_customer_details").data("id");

      var value = jQuery.ajax({
        url: ajaxurl,
        data: {
          username: username,
          nonce: nonce,
          email: email,
          phone: phone,
          title: title,
          postid: postid,
          optionid: optionid,
          action: "prepayment",
        },
        type: "POST",
        dataType: "json",
        success: function (data, textStatus, jqXHR) {
          if (data.response == "SUCCESS") {
            ErrorsManager.createEl("success", "Информация успешно обновлена");
          } else if (data.response == "ERROR") {
            ErrorsManager.createEl("error", "Ошибка: " + data.error);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          ErrorsManager.createEl("error", "Ошибка: " + errorThrown);
        },
      });
    }
  );
});

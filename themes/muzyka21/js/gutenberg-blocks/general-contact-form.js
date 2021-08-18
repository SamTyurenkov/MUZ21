"use strict";

$ = jQuery;
$(document).ready(function () {
  $('.general-contact-form_flex input[type="submit"]').on("click", function (e) {
    if (!ValidateEmail($(this).parent().find('input[type="email"]').val())) $(this).parent().find('input[type="email"]').addClass("input_invalid");
    if ($(this).parent().find(".general-contact-form_username").val().length < 1) $(this).parent().find(".general-contact-form_username").addClass("input_invalid");
    if ($(this).parent().find(".general-contact-form_userphone").val().length < 1 || !ValidatePhone($(this).parent().find(".general-contact-form_userphone").val())) $(this).parent().find(".general-contact-form_userphone").addClass("input_invalid");
    $(this).parent().parent().css("pointer-events", "none").css("opacity", "0.3");
    var el = this;
    var ajaxurl = localize.ajaxurl;
    var nonce = $("#_general_contact_form").val();
    var username = $(this).parent().find(".general-contact-form_username").val();
    var email = $(this).parent().find('input[type="email"]').val();
    var phone = $(this).parent().find(".general-contact-form_userphone").val();
    var page = $(this).parent().find(".general-contact-form_page").val();
    var value = jQuery.ajax({
      url: ajaxurl,
      data: {
        username: username,
        nonce: nonce,
        email: email,
        phone: phone,
        page: page,
        action: "general_contact_submission"
      },
      type: "POST",
      dataType: "json",
      success: function success(data, textStatus, jqXHR) {
        if (data.response == "SUCCESS") {
          ErrorsManager.createEl("success", "Запрос успешно создан");
        } else if (data.response == "ERROR") {
          ErrorsManager.createEl("error", "Ошибка: " + data.error);
        }

        $(el).parent().parent().css("pointer-events", "all").css("opacity", "1");
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        ErrorsManager.createEl("error", "Ошибка: " + errorThrown);
        $(el).parent().parent().css("pointer-events", "all").css("opacity", "1");
      }
    });
  });
});
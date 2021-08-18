$ = jQuery;
$(document).ready(function () {
var soldticketspage = 1;

	function getSoldTickets() {
		var ajaxurl = localize_editor.ajaxurl;
			var nonce = $("#_editor").val();
			var postid = localize_editor.postid;
			$(".editor-frame_buttons, .editor-frame_content").css("pointer-events", "none").css("opacity", "0.3");
			var ajax = jQuery.ajax({
				url: ajaxurl,
				data: {
					nonce: nonce,
					postid: postid,
					action: "getpurchases",
					paged: soldticketspage,
				},
				type: "POST",
				dataType: "json",
				success: function (data, textStatus, jqXHR) {
					if (data.response == "SUCCESS") {
						document.querySelector('.editor-frame_soldtickets').innerHTML += data.content;
						soldticketspage++;
					} else if (data.response == "ERROR") {
						ErrorsManager.createEl("error", "Ошибка: " + data.error);
					}
					$(".editor-frame_buttons, .editor-frame_content").css("pointer-events", "all").css("opacity", "1");
				},
				error: function (jqXHR, textStatus, errorThrown) {
					ErrorsManager.createEl("error", "Ошибка: " + errorThrown);
					$(".editor-frame_buttons, .editor-frame_content").css("pointer-events", "all").css("opacity", "1");
				},
			});
	}

	$(".editor-frame_buttons_sold").on("click", function (e) {
		e.stopPropagation();
		$(".editor-frame_soldtickets").addClass("active");
		$(".editor-frame_content").removeClass("active");
		if(soldticketspage == 1) {
			getSoldTickets();
		}
	});

	$(".editor-frame_buttons_edit").on("click", function (e) {
		e.stopPropagation();
		$(".editor-frame_content").addClass("active");
		$(".editor-frame_soldtickets").removeClass("active");
	});

	$(".editor-frame_buttons_close").on("click", function (e) {
		e.stopPropagation();
		$(".editor-frame_soldtickets").removeClass("active");
		$(".editor-frame_content").removeClass("active");
	});

	$(document).on("click", ".editor-frame_buttons_pending, .editor-frame_buttons_draft, .editor-frame_buttons_publish", function (e) {
		e.stopPropagation();
		$(".editor-frame_buttons, .editor-frame_content").css("pointer-events", "none").css("opacity", "0.3");
		var ajaxurl = localize_editor.ajaxurl;
		var nonce = $("#_editor").val();
		var postid = localize_editor.postid;
		var el = this;
		console.log(el.classList[1].toString());
		var ajax = jQuery.ajax({
			url: ajaxurl,
			data: {
				nonce: nonce,
				postid: postid,
				action: "seteventstatus",
				el: el.classList[1].toString(),
			},
			type: "POST",
			dataType: "json",
			success: function (data, textStatus, jqXHR) {
				if (data.response == "SUCCESS") {
					if (el.classList[1].toString() == "editor-frame_buttons_pending") {
						ErrorsManager.createEl("success", "Событие отправлено на модерацию");
						el.remove();
					} else {
						ErrorsManager.createEl("success", "Статус события изменен");
					}

				} else if (data.response == "ERROR") {
					ErrorsManager.createEl("error", "Ошибка: " + data.error);
				}
				$(".editor-frame_buttons, .editor-frame_content").css("pointer-events", "all").css("opacity", "1");
			},
			error: function (jqXHR, textStatus, errorThrown) {
				ErrorsManager.createEl("error", "Ошибка: " + errorThrown);
				$(".editor-frame_buttons, .editor-frame_content").css("pointer-events", "all").css("opacity", "1");
			},
		});
	});

	$(document).on("click", ".editor-frame_buttons_delete", function (e) {
		e.stopPropagation();
		$(".editor-frame_buttons, .editor-frame_content").css("pointer-events", "none").css("opacity", "0.3");
		var ajaxurl = localize_editor.ajaxurl;
		var nonce = $("#_editor").val();
		var postid = localize_editor.postid;

		var ajax = jQuery.ajax({
			url: ajaxurl,
			data: {
				nonce: nonce,
				postid: postid,
				action: "deleteevent",
			},
			type: "POST",
			dataType: "json",
			success: function (data, textStatus, jqXHR) {
				if (data.response == "SUCCESS") {
					ErrorsManager.createEl("success", "Событие и его переводы удалены");
					location.href = localize_editor.homeurl + "/author/" + localize_editor.uname;
				} else if (data.response == "ERROR") {
					ErrorsManager.createEl("error", "Ошибка: " + data.error);
				}
				$(".editor-frame_buttons, .editor-frame_content").css("pointer-events", "all").css("opacity", "1");
			},
			error: function (jqXHR, textStatus, errorThrown) {
				ErrorsManager.createEl("error", "Ошибка: " + errorThrown);
				$(".editor-frame_buttons, .editor-frame_content").css("pointer-events", "all").css("opacity", "1");
			},
		});
	});

	$(document).on("click", ".editor-frame_content_part_tickets_tab", function (e) {
		e.stopPropagation();
		var id = $(this).data("id");
		if (Number.isInteger(id)) {
			$(".editor-frame_content_part_tickets_tab").removeClass("active");
			$(".editor-frame_content_part_ticket").removeClass("active");
			$(this).addClass("active");
			$(".editor-frame_content_part_ticket[data-id=" + id + "]").addClass("active");
		} else if (id == "+") {
			var plus = this;
			$(".tickets_editor").css("pointer-events", "none").css("opacity", "0.3");

			var ajaxurl = localize_editor.ajaxurl;
			var nonce = $("#_editor").val();
			var postid = localize_editor.postid;

			var ajax = jQuery.ajax({
				url: ajaxurl,
				data: {
					nonce: nonce,
					postid: postid,
					action: "createnewticket",
				},
				type: "POST",
				dataType: "json",
				success: function (data, textStatus, jqXHR) {
					if (data.response == "SUCCESS") {
						ErrorsManager.createEl("success", "Создан новый тип билета");

						let curlen = parseInt(document.querySelectorAll(".editor-frame_content_part_tickets_tab").length) - 1;
						console.log(curlen, document.querySelectorAll(".editor-frame_content_part_tickets_tab"));

						let ticketNode = document.querySelector(".editor-frame_content_part_ticket");
						let ticketNodeClone = ticketNode.cloneNode(true);
						ticketNodeClone.setAttribute("data-id", curlen);
						$(".editor-frame_content_part_ticket").removeClass("active");
						ticketNodeClone.classList.add("active");
						let inputs = ticketNodeClone.querySelectorAll("textarea, input");
						for (var j = 0; j < inputs.length; j++) {
							try {
								inputs[j].value = "";
								inputs[j].innerHTML = "";
							} catch (e) {}
						}
						document.querySelector(".tickets_editor").append(ticketNodeClone);

						let ticketTabNode = document.querySelector(".editor-frame_content_part_tickets_tab");
						let ticketTabNodeClone = ticketTabNode.cloneNode(true);
						ticketTabNodeClone.innerHTML = curlen;
						ticketTabNodeClone.setAttribute("data-id", curlen);
						$(".editor-frame_content_part_tickets_tab").removeClass("active");
						ticketTabNodeClone.classList.add("active");
						document.querySelector(".editor-frame_content_part_tickets").insertBefore(ticketTabNodeClone, document.querySelector(".ticket_plus"));
					} else if (data.response == "ERROR") {
						ErrorsManager.createEl("error", "Ошибка: " + data.error);
					}
					$(".tickets_editor").css("pointer-events", "all").css("opacity", "1");
				},
				error: function (jqXHR, textStatus, errorThrown) {
					ErrorsManager.createEl("error", "Ошибка: " + errorThrown);
					$(".tickets_editor").css("pointer-events", "all").css("opacity", "1");
				},
			});
		}
	});

	$(document).on("click", ".editor-frame_content_part_ticket_delete", function (e) {
		e.stopPropagation();
		var ticketid = $(this).parent().parent().data("id");
		if (document.querySelectorAll(".editor-frame_content_part_ticket").length < 2) return;
		$(".tickets_editor").css("pointer-events", "none").css("opacity", "0.3");
		var ajaxurl = localize_editor.ajaxurl;
		var nonce = $("#_editor").val();
		var postid = localize_editor.postid;
		var el = this;

		var ajax = jQuery.ajax({
			url: ajaxurl,
			data: {
				nonce: nonce,
				postid: postid,
				ticketid: ticketid,
				action: "deleteticket",
			},
			type: "POST",
			dataType: "json",
			success: function (data, textStatus, jqXHR) {
				if (data.response == "SUCCESS") {
					ErrorsManager.createEl("success", "Билет удален");

					document.querySelectorAll(".editor-frame_content_part_tickets_tab")[ticketid].remove();
					$(el).parent().parent().remove();

					let tabs = document.querySelectorAll(".editor-frame_content_part_tickets_tab");
					let tickets = document.querySelectorAll(".editor-frame_content_part_ticket");

					for (var i = 0; i < tickets.length; i++) {
						tabs[i].classList.remove("active");
						tickets[i].classList.remove("active");
						tabs[i].innerHTML = i;
						tabs[i].setAttribute("data-id", i);
						tickets[i].setAttribute("data-id", i);
						if (i == 0) {
							tabs[i].classList.add("active");
							tickets[i].classList.add("active");
						}
					}
				} else if (data.response == "ERROR") {
					ErrorsManager.createEl("error", "Ошибка: " + data.error);
				}
				$(".tickets_editor").css("pointer-events", "all").css("opacity", "1");
			},
			error: function (jqXHR, textStatus, errorThrown) {
				ErrorsManager.createEl("error", "Ошибка: " + errorThrown);
				$(".tickets_editor").css("pointer-events", "all").css("opacity", "1");
			},
		});
	});

	$(document).on("change", ".option_price, .option_name, .option_description", function (e) {
		let value = this.value;
		let field = this.classList[1];
		let ticketid = $(this.parentNode.parentNode).data("id");
		var ajaxurl = localize_editor.ajaxurl;
		var nonce = $("#_editor").val();
		var postid = localize_editor.postid;

		var ajax = jQuery.ajax({
			url: ajaxurl,
			data: {
				nonce: nonce,
				postid: postid,
				action: "updateticketinfo",
				ticketid: ticketid,
				value: value,
				field: field,
			},
			type: "POST",
			dataType: "json",
			success: function (data, textStatus, jqXHR) {
				if (data.response == "SUCCESS") {
					ErrorsManager.createEl("success", "Информация обновлена");
				} else if (data.response == "ERROR") {
					ErrorsManager.createEl("error", "Ошибка: " + data.error);
				}
				plus.style.pointerEvents = "all";
			},
		});
	});

	$(document).on("change", ".event_title, .event_description, .event_date_start, .event_date_end, .event_place", function (e) {
		let value = this.value;
		let field = this.classList[1];
		var ajaxurl = localize_editor.ajaxurl;
		var nonce = $("#_editor").val();
		var postid = localize_editor.postid;

		var ajax = jQuery.ajax({
			url: ajaxurl,
			data: {
				nonce: nonce,
				postid: postid,
				action: "updateeventinfo",
				value: value,
				field: field,
			},
			type: "POST",
			dataType: "json",
			success: function (data, textStatus, jqXHR) {
				if (data.response == "SUCCESS") {
					ErrorsManager.createEl("success", "Информация обновлена");
				} else if (data.response == "ERROR") {
					ErrorsManager.createEl("error", "Ошибка: " + data.error);
				}
			},
		});
	});

	//update thumbnail
	var eventthumb = document.getElementById("eventthumb");
	eventthumb.addEventListener(
		"change",
		function (e) {
			console.log("change");
			var ajaxurl = localize_editor.ajaxurl;
			var postid = localize_editor.postid;
			var nonce = document.getElementById("_editor").value;
			//var posttype = '<?php echo esc_html(get_post_type()); ?>';

			this.parentElement.getElementsByTagName("label")[0].innerHTML = "Подождите";
			meta = this.files[0].name;
			file = this.files[0];

			if (file.type === "image/jpg" || file.type === "image/png" || file.type === "image/jpeg") {
				extension = true;
			} else {
				this.parentElement.getElementsByTagName("label")[0].style.background = "#fdd2d2";
				this.parentElement.getElementsByTagName("label")[0].innerHTML = "Только .jpg и .png";
			}

			if (extension === true) {
				var data = new FormData();
				data.append("file", file);
				data.append("postid", postid);
				data.append("nonce", nonce);
				data.append("meta", meta);
				data.append("place", "featured");

				data.append("action", "add_attachement_ajax");
				var value = jQuery.ajax({
					url: ajaxurl,
					data: data,
					type: "POST",
					cache: false,
					processData: false, // Don't process the files
					contentType: false, // Set content type to false as jQuery will tell the server its a query string request
					dataType: "json",
					success: function (data, textStatus, jqXHR) {
						var uthumb = document.getElementById("eventthumb"); //.parentElement.getElementsByTagName('label')[0];
						if (data.response == "SUCCESS") {
							uthumb.parentElement.getElementsByTagName("label")[0].style.background = "url('" + data.thumb + "') no-repeat center center";
							uthumb.parentElement.getElementsByTagName("label")[0].style.backgroundSize = "cover";
							ErrorsManager.createEl("success", "Изображение успешно загружено");
						}
						if (data.response == "ERROR") {
							uthumb.parentElement.getElementsByTagName("label")[0].style.background = "#fdd2d2";
							ErrorsManager.createEl("error", "Ошибка: " + data.error);
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						var uthumb = document.getElementById("eventthumb").parentElement.getElementsByTagName("label")[0];
						uthumb.parentElement.getElementsByTagName("label")[0].style.background = "#fdd2d2";
						ErrorsManager.createEl("error", "Ошибка: " + textStatus);
					},
				});
			}
		},
		true
	);
});

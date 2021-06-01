$ = jQuery;

var page = 1; //show first page of results
var posttype = 1; //by default show only properties
var selectors = document.querySelectorAll("#filters .custom-select select");

function resetquery() {
  page = 1;
  document.querySelector(".categories2").innerHTML = "";
  document.querySelector(".loadprops").innerHTML =
    '<i class="icon-plus"></i> Загрузить еще';
  loadproperties();
}

function canUseWebP() {
  var elem = document.createElement("canvas");

  if (!!(elem.getContext && elem.getContext("2d"))) {
    // was able or not to get WebP representation
    return elem.toDataURL("image/webp").indexOf("data:image/webp") == 0;
  }

  // very old browser like IE 8, canvas not supported
  return false;
}

function loadproperties() {
  if (typeof localize == "undefined") return;
  var action = localize.action;
  var obj_id = parseInt(localize.obj_id);
  var ajaxurl = localize.ajaxurl;

  var selected = [];
  if (selectors) {
    for (var i = 0; i < selectors.length; i++) {
      selected[i] = selectors[i].value;
    }
  }

  var value = jQuery.ajax({
    type: "GET",
    url: ajaxurl,
    data: {
      page: page,
      obj_id: obj_id, //optional
      options: selected, //optional
      action: action,
      posttype: posttype, //optional
    },
    success: function (data, textStatus, jqXHR) {
      page++;
      var addwebp = data["response"];
      if (canUseWebP() == true) {
        addwebp = addwebp.split(".png").join(".png.webp");
        addwebp = addwebp.split(".jpg").join(".jpg.webp");
        addwebp = addwebp.split(".jpeg").join(".jpeg.webp");
      }

      document.querySelector(".categories2").innerHTML += addwebp;
      if (data.amount < 9) {
        document.querySelector(".loadprops").innerHTML =
          "Больше объявлений нет";
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("ajax error in query");
    },
  });
}

$(document).ready(function () {
  $(".loadprops").on("click", function () {
    console.log("loadmore");
    loadproperties();
  });

  var dropdowns = document.querySelectorAll("#filters .select-items div");
  for (var n = 0; n < dropdowns.length; n++) {
    dropdowns[n].addEventListener(
      "click",
      function () {
        console.log("reset");
        resetquery();
      },
      false
    );
  }

  if (window.location.hash === "#blog") {
    document.querySelector("#querystatus select").value = "pending";
    showPosts();
  } else if (window.location.hash === "#props") {
    document.querySelector("#querystatus select").value = "pending";
    showProps();
  } else {
    loadproperties();
  }
});

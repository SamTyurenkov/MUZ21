$ = jQuery;
$(document).ready(function () {
//logout
var logout = document.getElementById("logout");
logout.addEventListener("click", function(e) {
    var ajaxurl = localize.ajaxurl;
    var nonce = document.getElementById("_editauthmeta").value;

    var value = jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        cache: false,
        data: {
            nonce: nonce,
            action: 'logout',
        },
        success: function(data, textStatus, jqXHR) {
            window.open(localize.homeurl, "_self");
        },
        error: function(jqXHR, textStatus, errorThrown) {
            window.open(localize.homeurl, "_self");
        }
    });

});
});
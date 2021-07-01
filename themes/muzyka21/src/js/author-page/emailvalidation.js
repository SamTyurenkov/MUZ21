$ = jQuery;
$(document).ready(function () {
var submit = document.getElementById("valisend");
    submit.addEventListener("click", function(e) {
        e.preventDefault();

        var ajaxurl = localize.ajaxurl;
        var id = localize.uid;
        var nonce = document.getElementById("_vali_send").value;

        var value = jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            cache: false,
            data: {
                id: id,
                nonce: nonce,
                action: 'valisend',
            },
            success: function(data, textStatus, jqXHR) {
                document.getElementById("valisend").style.pointerEvents = 'none';
                document.getElementById("valisend").style.background = '#f2f2f2';
                ErrorsManager.createEl('success','Письмо успешно отправлено'); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('val.error');
                document.getElementById("valisend").style.pointerEvents = 'none';
                document.getElementById("valisend").style.background = '#f2f2f2';
                ErrorsManager.createEl('error','Ошибка: ' + textStatus);
            }
        })
    }, true);
});
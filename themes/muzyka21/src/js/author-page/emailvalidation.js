$ = jQuery;
$(document).ready(function () {
$('#valisend').on("click", function(e) {
        e.preventDefault();

        var ajaxurl = localize.ajaxurl;
        var nonce = document.getElementById("_vali_send").value;

        var value = jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            cache: false,
            data: {
                nonce: nonce,
                action: 'valisend',
            },
            success: function(data, textStatus, jqXHR) {
                document.getElementById("valisend").style.pointerEvents = 'none';
                ErrorsManager.createEl('success','Письмо успешно отправлено'); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('val.error');
                document.getElementById("valisend").style.pointerEvents = 'none';
                ErrorsManager.createEl('error','Ошибка: ' + textStatus);
            }
        })
    });
});
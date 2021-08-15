$ = jQuery;
$(document).ready(function () {
$('#valisend').on("click", function(e) {
        e.preventDefault();
        $('.emailvalidation-form').css('pointer-events','none').css('opacity:0.3');
        var ajaxurl = localize_author.ajaxurl;
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
                $('.emailvalidation-form').css('pointer-events','all').css('opacity:1');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('val.error');
                document.getElementById("valisend").style.pointerEvents = 'none';
                ErrorsManager.createEl('error','Ошибка: ' + textStatus);
                $('.emailvalidation-form').css('pointer-events','all').css('opacity:1');
            }
        })
    });
});
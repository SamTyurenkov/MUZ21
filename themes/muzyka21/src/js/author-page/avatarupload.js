$ = jQuery;
$(document).ready(function () {

//update thumbnail
var uthumb = document.getElementById("userthumb");
uthumb.addEventListener("change", function(e) {

    var ajaxurl = localize_author.ajaxurl;
    var id = localize_author.aid;
    var nonce = document.getElementById("_editauthmeta").value;
    var extension = false;

    this.parentElement.getElementsByTagName('label')[0].innerHTML = 'Подождите';
    meta = this.files[0].name;
    file = this.files[0];

    if (file.type === "image/jpg" || file.type === "image/png" || file.type === "image/jpeg") {
        extension = true;
    } else {
        this.parentElement.getElementsByTagName('label')[0].style.background = '#fdd2d2';
        ErrorsManager.createEl('error','Ошибка: только JPG или PNG файлы');
    }

    if (extension === true) {
        var data = new FormData();
        data.append('file', file);
        data.append('id', id);
        data.append('nonce', nonce);
        data.append('meta', meta);
        data.append('action', 'updateavatar');
        var value = jQuery.ajax({
            url: ajaxurl,
            data: data,
            type: 'POST',
            cache: false,
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            dataType: 'json',
            success: function(data, textStatus, jqXHR) {
                var uthumb = document.getElementById("userthumb").parentElement.getElementsByTagName('label')[0];
                console.log('data.response ' + data["response"] + ' ' + textStatus);
                if (data.response == 'SUCCESS') {
                    ErrorsManager.createEl('success','Аватар успешно обновлен.'+ data.details);
                    uthumb.style.backgroundImage = "url('" + data.thumb + '?v='+ data.version+"')";
                    uthumb.style.backgroundSize = 'cover';
                }
                if (data.response == 'ERROR') {
                    uthumb.style.background = '#fdd2d2';
                    ErrorsManager.createEl('error','Ошибка: ' + data.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var uthumb = document.getElementById("userthumb").parentElement.getElementsByTagName('label')[0];
                uthumb.style.background = '#fdd2d2';
                ErrorsManager.createEl('error','Ошибка: ' + errorThrown);
            }
        })
    }

}, true);

});
$ = jQuery;
$(document).ready(function () {

function updatemetas(field) {

    if (field.parentNode.parentNode.classList[0] == 'custom-select') {
        var name = field.parentNode.parentNode.id;
        var meta = field.innerHTML;
    } else {
        var name = field.classList[1];
        var meta = field.value;
    }

    var ajaxurl = localize_author.ajaxurl;
    var id = localize_author.aid;
    var nonce = document.getElementById("_editauthmeta").value;

    var value = jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        cache: false,
        data: {
            meta: meta,
            id: id,
            name: name,
            nonce: nonce,
            action: 'updateauth',
        },
        success: function(data, textStatus, jqXHR) {
            if (data.response == "SUCCESS") {
                ErrorsManager.createEl('success', 'Информация успешно обновлена'); 
            } else if (data.response == "ERROR") {
                ErrorsManager.createEl('error','Ошибка: ' + data.error); 
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            ErrorsManager.createEl('error','Ошибка: ' + errorThrown); 
        }
    })
};

var fields = document.querySelectorAll('.editauthor .text, .integration .text');
for (var i = 0; i < fields.length; i++) {

    fields[i].addEventListener("change", function() {
        updatemetas(this);
    }, false);
};

var selects = document.querySelectorAll('#settings .select-items div');
for (var i = 0; i < selects.length; i++) {
    selects[i].addEventListener("click", function() {
        updatemetas(this);
    }, false);
};

});
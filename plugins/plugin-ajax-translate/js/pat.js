//"{$repeater_name}_{$index}_{$sub_repeater_name}_{$index}_{$sub_field_name}"

/**
 *
 * @param field
 */
function addTranslateBtn(field) {
    field.$el.find(".acf-input").each(function (i, e) {
        jQuery(this).append(
            '<div class="pat_button button">TRANSLATE</div>'
        );
    });
}

if (typeof acf !== "undefined") {
    acf.addAction("ready_field/type=text", function (field) {
        addTranslateBtn(field);
    });

    acf.addAction("ready_field/type=textarea", function (field) {
        addTranslateBtn(field);
    });

    acf.addAction("ready_field/type=wysiwyg", function (field) {
        addTranslateBtn(field);
    });

    acf.addAction("ready_field/type=image", function (field) {
        addTranslateBtn(field);
    });
}

jQuery(document).ready(function () {
    var textareas = jQuery(".pat_popup textarea");
    var canGetVals = true;
    var pat_save = function () {
        //console.log('trying to save');
        // Get the selectbox values
        var field = jQuery(this);
        var dest_post_id = jQuery(this).attr("dest-post-id");
        var dest_field_id = jQuery(this).attr("dest-field-id");
        var dest_field_name = jQuery(this).attr("dest_field_name");
        var dest_val = jQuery(this).val();

        // Setup all the data we have for ajax post rquest
        var data = {
            action: "pat_setvals",
            dest_post_id: dest_post_id,
            dest_field_id: dest_field_id,
            dest_field_name: dest_field_name,
            dest_val: dest_val,
        };

        //console.log(ajaxurl, data);

        // Post ajax request
        jQuery.post(ajaxurl, data, function (response) {
            if (response) {

                response = JSON.parse(response);
                if (response.result == true) {
                    field.css('border', '3px solid green');
                } else {
                    field.css('border', '3px solid red');
                }
            }
        });
    };

    jQuery(".pat_popup_close").on("click", function () {
        jQuery(".pat_popup").css("display", "none");
    });

    jQuery(".pat_button").on("click", function () {
        if (canGetVals == false) return;
        canGetVals = false;

        jQuery(".pat_popup_inputs").html('');
        jQuery(".pat_popup").css("display", "block");

        var post_id = localize_obj.post_id;
        var post_type = localize_obj.post_type;
        var field_type = jQuery(this).parent().parent().attr("data-type");
        var field_id = jQuery(this).parent().parent().attr("data-key");
        if (field_type != 'wysiwyg') {
            var field_name = jQuery(this).parent().parent().find('textarea,input').attr("name");
        } else {
            var field_name = jQuery(this).parent().parent().find('textarea.wp-editor-area').attr("name");
        }
        console.log(field_name);
        // Setup all the data we have for ajax post request
        var data = {
            action: "pat_getvals",
            post_id: post_id,
            post_type: post_type,
            field_id: field_id,
            field_name: field_name
        };
        // Post ajax request
        jQuery.post(ajaxurl, data, function (response) {
            if (response) {
                response = JSON.parse(response);
                //console.log(response);

                Object.getOwnPropertyNames(response).forEach(function (val, idx, array) {

                    var container = document.createElement("div");
                    container.classList.add('pat_popup_input');

                    var textarea = document.createElement("textarea");
                    var label = document.createElement("label");

                    label.innerHTML = val;
                    textarea.value = response[val]['field_val'];

                    textarea.setAttribute('dest-post-id', response[val]['dest_post_id']);
                    textarea.setAttribute('dest_field_id', response[val]['dest_field_id']);
                    textarea.setAttribute('dest_field_name', response[val]['dest_field_name']);
                    container.appendChild(label);
                    container.appendChild(textarea);
                    jQuery(".pat_popup_inputs").append(container);
                });

                canGetVals = true;
                textareas = jQuery(".pat_popup textarea");
                textareas.on("change", pat_save); //console.log(textareas);
            }
        });
    });
});

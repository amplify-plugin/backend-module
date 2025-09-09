/*
*
* Backpack Crud
*
*/

jQuery(function ($) {

    'use strict';

    $("#code").on("keyup", function () {
        let code = $(this).val();
        code = JSON.parse(code);
        let formatting = JSON.stringify(code, undefined, 4);
        $(this).val(formatting);
    });

    /* CMS configuration */
    if ($("#value_type").val() == 'string') {
        $("#value_string").parent().show();
        $("#value_image").parent().parent().parent().hide();
    }

    if ($("#value_type").val() == 'image') {
        $("#value_string").parent().hide();
        $("#value_image").parent().parent().parent().show();
    }

    $("#value_type").on('change', function () {
        if ($("#value_type").val() == 'string') {
            $("#value_image").parent().parent().parent().hide();
            $("#value_string").parent().show();
        } else if($("#value_type").val() == 'image') {
            $("#value_string").parent().hide();
            $("#value_image").parent().parent().parent().show();
        }
    });

});

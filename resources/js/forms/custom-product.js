crud.field('ref_link').onChange(function(field) {
    $('#product-ref-link').attr('href', field.value);
}).change();

crud.field('value').onChange(function(field) {
    try {
        JSON.parse(field.value);
        $('#json-validation-error').html('');
    } catch (e) {
        $('#json-validation-error').html('Invalid JSON: ' + e.message);
    }
}).change();

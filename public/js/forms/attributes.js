'use strict';

$(document).ready(function () {
    crud.field('type').onChange(function (field) {
        let value = field.value;
        value === 'date' ? crud.field('has_range').check(1) : crud.field('has_range').check(0); // Set default for date type
        value === 'select' ? crud.field('select_options').show() : crud.field('select_options').hide();
    }).change();
});

$(document).ready(function () {
    crud.field('formFields').subfield('type').onChange(function (field) {
        let value = field.value;
        let rowNumber = field.rowNumber;
         crud.field('formFields').subfield('options', rowNumber).show((['rSelect', 'rCheckbox', 'rRadio']).includes(value));
         crud.field('formFields').subfield('minimum', rowNumber).show((['rRange', 'rSelectRange', 'rSelectYear']).includes(value));
         crud.field('formFields').subfield('maximum', rowNumber).show((['rRange', 'rSelectRange', 'rSelectYear']).includes(value));
    }).change();
});

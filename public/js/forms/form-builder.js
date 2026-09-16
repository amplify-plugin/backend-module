crud.field('formFields').subfield('type').onChange(function (field) {
    let value = field.value;
    let rowNumber = field.rowNumber;
    crud.field('formFields').subfield('options', rowNumber).show((['rSelect', 'rCheckbox', 'rRadio']).includes(value));
    crud.field('formFields').subfield('minimum', rowNumber).show((['rRange', 'rSelectRange', 'rSelectYear']).includes(value));
    crud.field('formFields').subfield('maximum', rowNumber).show((['rRange', 'rSelectRange', 'rSelectYear']).includes(value));

    crud.field('formFields').subfield('name', rowNumber).hide(value === 'rHtml');
    crud.field('formFields').subfield('label', rowNumber).hide(value === 'rHtml');
    crud.field('formFields').subfield('is_required', rowNumber).hide(value === 'rHtml');
    crud.field('formFields').subfield('is_inline', rowNumber).hide(value === 'rHtml');
    crud.field('formFields').subfield('validation', rowNumber).hide(value === 'rHtml');
}).change();

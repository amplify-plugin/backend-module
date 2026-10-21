function menuTypeChanged(element) {
    let value = element.value;
    console.log(value, crud);
}

crud.field('menus').subfield('type').onChange(function (field) {
    crud.field('menus').subfield('url_type', field.rowNumber).show(field.value === 'default');
    crud.field('menus').subfield('url', field.rowNumber).show(field.value === 'default');
    crud.field('menus').subfield('page_id', field.rowNumber).show(field.value === 'default');
});


// crud.field('wish').subfield('country').onChange(function (field) {
//     crud.field('wish').subfield('body', field.rowNumber).enable(field.value == '');
// });

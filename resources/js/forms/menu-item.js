crud.field('type').onChange(function (field) {
    toggleFieldsBasedOnType(field.value);
});

function toggleFieldsBasedOnType(type) {
    switch (type) {
        case 'categories':
            crud.field('seo_path').show();
            crud.field('sub_category_depth').show();
            crud.field('display_product_count').show();
            crud.field('page_id').hide();
            crud.field('url').hide();
            crud.field('url_type').hide();
            break;

        case 'mega-menu':
            crud.field('seo_path').hide();
            crud.field('sub_category_depth').hide();
            crud.field('display_product_count').hide();
            crud.field('page_id').hide();
            crud.field('url').hide();
            crud.field('url_type').hide();
            break;

        default:
            crud.field('seo_path').hide();
            crud.field('sub_category_depth').hide();
            crud.field('display_product_count').hide();
            crud.field('page_id').show();
            crud.field('url').show();
            crud.field('url_type').show();
            break;
    }
}

toggleFieldsBasedOnType(crud.field('type').value);

crud.field('url_type').onChange(function (field) {
    crud.field('url').show(field.value == 'external');
    crud.field('page_id').show(field.value == 'page');
});
// crud.field('punch_out').onChange(function (field) {
//     crud.field('punch_out_configuration').show(field.value == '1');
// });

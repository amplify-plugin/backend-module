// crud.field('datasource').onChange(function(field) {
//     crud.field('reportConditions').subfield('column').setOptions({
//         'order_type': 'Order Type',
//         'order_status': 'Order Status',
//         'approval_status': 'Approval Status',

//     });
//  }).change();

crud.field('datasource').onChange(function(field) {
    console.log(crud.field('reportConditions').subfield('column').setOptions);
    crud.field('reportConditions').subfield('column');
});

// Optionally, trigger the change event after setting the options
crud.field('datasource').change();

// $this->crud->field('range')->type('select_from_array)->label(__('number range'))
//    ->options(Group::NUMBER_RANGE);
crud.field('punch_out').onChange(function(field) {
    crud.field('punch_out_configuration').show(field.value == 1);
}).change();

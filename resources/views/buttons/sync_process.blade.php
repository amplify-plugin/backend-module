<a href="javascript:void(0)" role="button" onclick="processProduct(event, this);"
   data-route="{{ url($crud->route.'/'.$entry->getKey().'/process') }}"
   class="btn btn-sm btn-link"
   data-button-type="Process">
    <span><i class="la la-sync"></i> Process </span>
</a>
<script>
    if (typeof processProduct != 'function') {
        function processProduct(event, element) {
            event.preventDefault();
            var button = $(element);
            var route = button.attr('data-route');

            $.ajax({
                url: route,
                type: 'GET',
                success: function (result) {
                    // Show an alert with the result
                    console.log(result, route);

                    new Noty({
                        text: "Product sync successfully",
                        type: "success"
                    }).show();

                    crud.table.ajax.reload();
                },
                error: function (result) {
                    new Noty({
                        text: "Something went wrong!!!",
                        type: "warning"
                    }).show();
                }
            });
        }
    }
</script>

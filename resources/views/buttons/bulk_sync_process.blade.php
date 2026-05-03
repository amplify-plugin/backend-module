@if ($crud->get('list.bulkActions'))
    <a href="javascript:void(0)" onclick="bulkProcessEntries(this, 'selected')"
       class="btn btn-sm btn-secondary bulk-button mr-3">
        <i class="la la-sync"></i> Process Selected</a>

    <a href="javascript:void(0)" onclick="bulkProcessEntries(this, 'all')"
       class="btn btn-sm btn-warning">
        <i class="la la-sync-alt"></i> Process All</a>
@endif

@push('after_scripts')
    <script>
        if (typeof bulkProcessEntries != 'function') {
            function bulkProcessEntries(button, selection) {

                //no item selected wearing
                if (selection === 'selected') {
                    if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length === 0) {
                        new Noty({
                            type: "warning",
                            text: "<strong>{!! trans('backpack::crud.bulk_no_entries_selected_title') !!}</strong><br>{!! trans('backpack::crud.bulk_no_entries_selected_message') !!}"
                        }).show();

                        return;
                    }
                }

                var message = (selection === 'all')
                    ? "Are you sure you want to process all entries?"
                    : ("Are you sure you want to process these :number entries?").replace(":number", crud.checkedItems.length);

                button = $(button);

                // show confirm message
                swal({
                    title: "{!! trans('backpack::base.warning') !!}",
                    text: message,
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "{!! trans('backpack::crud.cancel') !!}",
                            value: null,
                            visible: true,
                            className: "bg-secondary",
                            closeModal: true,
                        },
                        delete: {
                            text: "Process",
                            value: true,
                            visible: true,
                            className: "bg-warning",
                        }
                    },
                })
                    .then((value) => {
                        if (value) {
                            var ajax_calls = [];
                            var sync_process_route = "{{ url($crud->route) }}/bulk-process";

                            // submit an AJAX delete call
                            $.ajax({
                                url: sync_process_route,
                                type: 'POST',
                                data: {"selection": selection, "entries": crud.checkedItems},
                                success: function (result) {
                                    // Show notification bubble
                                    new Noty({
                                        type: result.type,
                                        text: result.message
                                    }).show();
                                    crud.table.ajax.reload();
                                },
                                error: function (result) {
                                    // Show an alert with the result
                                    new Noty({
                                        type: "warning",
                                        text: "<strong>Catalog Sync process failed.</strong><br>See detail: <a href='{{ backpack_url('failed-job') }}' target='_blank'>Fail Job Log</a>"
                                    }).show();
                                }
                            });
                        }
                    });
            }
        }
    </script>
@endpush

@if ($crud->hasAccess('bulkErpSync'))
    <a href="javascript:void(0)" onclick="bulkCustomerProfileSync(this)"
       class="m-2 btn btn-info bulk-button">
        <i class="las la-sync"></i>
        {!! trans('backpack::crud.erp-sync') !!}
    </a>
    @push('after_scripts')
        <script>
            if (typeof bulkCustomerProfileSync != 'function') {
                function bulkCustomerProfileSync(button) {

                    if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0) {
                        new Noty({
                            type: "warning",
                            text: "<strong>{!! trans('backpack::crud.bulk_no_entries_selected_title') !!}</strong><br>{!! trans('backpack::crud.bulk_no_entries_selected_message') !!}"
                        }).show();

                        return;
                    }

                    var message = ("{!! trans('backpack::crud.bulk_profile_sync_are_you_sure') !!}").replace(":number", crud.checkedItems.length);
                    var button = $(this);

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
                            publish: {
                                text: "{!! trans('backpack::crud.erp-sync') !!}",
                                value: true,
                                visible: true,
                                className: "bg-success",
                            }
                        },
                    }).then((value) => {
                        if (value) {
                            var ajax_calls = [];
                            var sync_route = "{{ url($crud->route) }}/bulk-profile-sync";

                            // submit an AJAX publish call
                            $.ajax({
                                url: sync_route,
                                type: 'POST',
                                data: {entries: crud.checkedItems},
                                success: function (result) {
                                    if (result.status) {
                                        // Show a success notification bubble
                                        new Noty({
                                            type: "success",
                                            text: "<strong>{!! trans('backpack::crud.bulk_profile_sync_title') !!}</strong><br>{!! trans('backpack::crud.bulk_profile_sync_success_message') !!}"
                                        }).show();
                                    } else {
                                        new Noty({
                                            type: "error",
                                            text: "<strong>{!! trans('backpack::crud.bulk_profile_sync_title') !!}</strong><br>" + result.message
                                        }).show();
                                    }

                                    crud.checkedItems = [];
                                    crud.table.draw(false);
                                },
                                error: function () {
                                    // Show an alert with the result
                                    new Noty({
                                        type: "warning",
                                        text: "<strong>{!! trans('backpack::crud.bulk_profile_sync_title') !!}</strong><br>{!! trans('backpack::crud.bulk_profile_sync_error_message') !!}"
                                    }).show();
                                }
                            });
                        }
                    });
                }
            }
        </script>
    @endpush
@endif
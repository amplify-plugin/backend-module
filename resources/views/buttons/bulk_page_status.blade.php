{{-- @if ($crud->hasAccess('bulkStatus') && $crud->get('list.bulkActions'))
	<a href="javascript:void(0)" onclick="bulkStatusEntries(this)" class="btn btn-sm btn-secondary bulk-button"><i class="la la-trash"></i> {{ trans('backpack::crud.status') }}</a>
@endif --}}
<div class="d-inline-block">
    <select class="form-control custom-select" id="status" style="width: 135px" name="status" onchange="bulkStatusEntries()">
        <option value="" selected>Change Status</option>
        <option value="1">Publish</option>
        <option value="0">Draft</option>
    </select>
</div>
@push('after_scripts')
    <script>
        if (typeof bulkStatusEntries != 'function') {
            function bulkStatusEntries(button) {
                if ($('#status').val() == "") return;
                if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0) {
                    new Noty({
                        type: "warning",
                        text: "<strong>{!! trans('backpack::crud.bulk_no_entries_selected_title') !!}</strong><br>{!! trans('backpack::crud.bulk_no_entries_selected_message') !!}"
                    }).show();

                    return;
                }

                var message = ("{!! trans('backpack::crud.bulk_status_are_you_sure') !!}").replace(":number", crud.checkedItems.length);
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
                        confirm: {
                            text: "{!! trans('backpack::crud.confirm') !!}",
                            value: true,
                            visible: true,
                            className: "bg-danger",
                        }
                    },
                }).then((value) => {
                    if (value) {
                        var ajax_calls = [];
                        var status_route = "{{ url($crud->route) }}/bulk-status";

                        // submit an AJAX status call
                        $.ajax({
                            url: status_route,
                            type: 'POST',
                            data: {entries: crud.checkedItems, status: $('#status').val()},
                            success: function (result) {
                                if (result > 0) {
                                    $('#status').val("");
                                    let changedBefore = Number(crud.checkedItems.length) - Number(result);
                                    let changedBeforeMessage = "";
                                    if (changedBefore > 0) {
                                        changedBeforeMessage = changedBefore + "{!! trans('backpack::crud.bulk_status_change_before_message') !!}";
                                    }
                                    // Show a success notification bubble
                                    new Noty({
                                        type: "success",
                                        text: "<strong>{!! trans('backpack::crud.bulk_status_sucess_title') !!}</strong><br>" + result + "{!! trans('backpack::crud.bulk_status_sucess_message') !!}<br>" + changedBeforeMessage
                                    }).show();
                                } else {
                                    // if the result is an array, it means
                                    // we have notification bubbles to show
                                    if (result instanceof Object) {
                                        // trigger one or more bubble notifications
                                        Object.entries(result).forEach(function (entry, index) {
                                            var type = entry[0];
                                            entry[1].forEach(function (message, i) {
                                                new Noty({
                                                    type: type,
                                                    text: message
                                                }).show();
                                            });
                                        });
                                    } else {
                                        // Show a warning notification bubble
                                        new Noty({
                                            type: "warning",
                                            text: "<strong>{!! trans('backpack::crud.bulk_status_error_title') !!}</strong><br>{!! trans('backpack::crud.bulk_status_error_message') !!}"
                                        }).show();
                                    }
                                }

                                // Move to previous page in case of deleting all the items in table
                                if (crud.table.rows().count() === crud.checkedItems.length) {
                                    crud.table.page("previous");
                                }

                                crud.checkedItems = [];
                                crud.table.draw(false);
                            },
                            error: function (result) {
                                // Show an alert with the result
                                new Noty({
                                    type: "warning",
                                    text: "<strong>{!! trans('backpack::crud.bulk_status_error_title') !!}</strong><br>{!! trans('backpack::crud.bulk_status_error_message') !!}"
                                }).show();
                            }
                        });
                    }
                });
            }
        }
    </script>
@endpush

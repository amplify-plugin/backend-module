{{-- @if ($crud->hasAccess('archive') && $crud->get('list.bulkActions')) --}}
<a href="javascript:void(0)" onclick="bulkPublishEntries(this)" class="m-2 btn btn-info bulk-button"><i
        class="las la-check-circle"></i> {!! trans('backpack::crud.publish') !!}</a>
{{-- @endif --}}

@push('after_scripts')
    <script>
        if (typeof bulkPublishEntries != 'function') {
            function bulkPublishEntries(button) {

                if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0) {
                    new Noty({
                        type: "warning",
                        text: "<strong>{!! trans('backpack::crud.bulk_no_entries_selected_title') !!}</strong><br>{!! trans('backpack::crud.bulk_no_entries_selected_message') !!}"
                    }).show();

                    return;
                }

                var message = ("{!! trans('backpack::crud.bulk_publish_are_you_sure') !!}").replace(":number", crud.checkedItems.length);
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
                            text: "{!! trans('backpack::crud.publish') !!}",
                            value: true,
                            visible: true,
                            className: "bg-success",
                        }
                    },
                }).then((value) => {
                    if (value) {
                        firePublishAction();
                    }
                });
            }

            function firePublishAction(item_id = null) {
                var ajax_calls = [];
                var publish_route = "{{ url($crud->route) }}/bulk-publish";
                let item_affected_length = item_id ? 1 : crud.checkedItems.length;

                // submit an AJAX publish call
                $.ajax({
                    url: publish_route,
                    type: 'POST',
                    data: {
                        entries: item_id ? [item_id] : crud.checkedItems
                    },
                    success: function(result) {
                        if (result > 0) {
                            // Show a success notification bubble
                            let publishedBefore = Number(item_affected_length) - Number(result);
                            let publishedBeforeMessage = "";
                            if (publishedBefore > 0) {
                                publishedBeforeMessage = publishedBefore + "{!! trans('backpack::crud.bulk_publish_before_message') !!}";
                            }
                            new Noty({
                                type: "success",
                                text: "<strong>{!! trans('backpack::crud.bulk_publish_sucess_message') !!}</strong><br>" + result +
                                    "{!! trans('backpack::crud.bulk_publish_sucess_message') !!}<br>" + publishedBeforeMessage
                            }).show();
                        } else {
                            // we have notification bubbles to show
                            if (result instanceof Object) {
                                // trigger one or more bubble notifications
                                Object.entries(result).forEach(function(entry, index) {
                                    var type = entry[0];
                                    entry[1].forEach(function(message, i) {
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
                                    text: "<strong>{!! trans('backpack::crud.bulk_publish_error_title') !!}</strong><br>{!! trans('backpack::crud.bulk_publish_error_message') !!}"
                                }).show();
                            }
                        }

                        // Move to previous page in case of deleting all the items in table
                        if (crud.table.rows().count() === item_affected_length) {
                            crud.table.page("previous");
                        }

                        crud.checkedItems = [];
                        crud.table.draw(false);
                    },
                    error: function(result) {
                        // Show an alert with the result
                        new Noty({
                            type: "warning",
                            text: "<strong>{!! trans('backpack::crud.bulk_publish_error_title') !!}</strong><br>{!! trans('backpack::crud.bulk_publish_error_message') !!}"
                        }).show();
                    }
                });
            }
        }
    </script>
@endpush

@if ($crud->hasAccess('bulkExport') && $crud->get('list.bulkActions'))
	<a href="javascript:void(0)" onclick="bulkDeleteEntries(this)" class="btn btn-sm btn-warning bulk-button"><i class="la la-download"></i> {{ trans('backpack::crud.export.export') }}</a>
@endif

@push('after_scripts')
<script>
	if (typeof bulkDeleteEntries != 'function') {
	  function bulkDeleteEntries(button) {

	      if (typeof crud.checkedItems === 'undefined' || crud.checkedItems.length == 0)
	      {
	      	new Noty({
	          type: "warning",
	          text: "<strong>{!! trans('backpack::crud.bulk_no_entries_selected_title') !!}</strong><br>{!! trans('backpack::crud.bulk_no_entries_selected_message') !!}"
	        }).show();

	      	return;
	      }

	      var message = ("Are you sure you want to export these :number entries?").replace(":number", crud.checkedItems.length);
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
			  	delete: {
				  text: "{!! trans('backpack::crud.export.export') !!}",
				  value: true,
				  visible: true,
				  className: "bg-success",
				}
			  },
			}).then((value) => {
				if (value) {
					// submit a real form POST so the browser handles the file download natively
					var form = $('<form>', {
						action: "{{ url($crud->route) }}/bulk-export",
						method: 'POST'
					});

					form.append($('<input>', {
						type: 'hidden',
						name: '_token',
						value: '{{ csrf_token() }}'
					}));

					crud.checkedItems.forEach(function(id) {
						form.append($('<input>', {
							type: 'hidden',
							name: 'entries[]',
							value: id
						}));
					});

					form.appendTo('body').submit().remove();
				}
			});
      }
	}
</script>
@endpush

@if ($crud->hasAccess('clone'))
  @if (! $entry->has_sku )
    @if ($entry->parent_id)
      <a title="This product already mastered !" class="m-2 btn btn-sm btn-link" data-button-type="clone"><i class="la la-copy"></i> {{ trans('Make as Master') }}</a>
    @else
      <a href="javascript:void(0)" onclick="cloneEntry(this)" title="This product is a normal product."
      data-route="{{ url($crud->route.'/'.$entry->getKey().'/clone') }}" class="m-2 btn btn-sm btn-link" data-button-type="clone"><i class="la la-copy"></i> {{ trans('Make as Master') }}</a>
    @endif
  @else
    <a title="This product can't be a master product." class="m-2 btn btn-sm btn-link" data-button-type="clone"><i class="la la-copy"></i> {{ trans('Make as Master') }}</a>
  @endif
@endif

{{-- Button Javascript --}}
{{-- - used right away in AJAX operations (ex: List) --}}
{{-- - pushed to the end of the page, after jQuery is loaded, for non-AJAX operations (ex: Show) --}}
@push('after_scripts') @if (request()->ajax()) @endpush @endif
<script>
	if (typeof cloneEntry != 'function') {
	  $("[data-button-type=clone]").unbind('click');

	  function cloneEntry(button) {
	      // ask for confirmation before deleting an item
	      // e.preventDefault();
	      var button = $(button);
	      var route = button.attr('data-route');

          $.ajax({
              url: route,
              type: 'POST',
              success: function(result) {
                  // Show an alert with the result
                  new Noty({
                    type: "success",
                    text: "{!! trans('backpack::crud.clone_success') !!}"
                  }).show();

                  // Hide the modal, if any
                  $('.modal').modal('hide');

                  if (typeof crud !== 'undefined') {
                    crud.table.draw(false);
                  }
              },
              error: function(e) {
                  new Noty({
                      type: 'error',
                      text: JSON.parse(e.responseText)?.message
                  }).show();
              }
          });
      }
	}

	// make it so that the function above is run after each DataTable draw event
	// crud.addFunctionToDataTablesDrawEventQueue('cloneEntry');
</script>
@if (!request()->ajax()) @endpush @endif

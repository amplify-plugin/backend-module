@if ($crud->hasAccess('update'))
<a href="{{ $entry->deleted_at ? url($crud->route.'/'.$entry->getKey().'/activate') : url($crud->route.'/'.$entry->getKey().'/deactivate') }} "
   class="m-2 btn btn-sm btn-link">
    <i class="fa fa-ban"></i>
    {{ $entry->deleted_at ? 'Activate' : 'Deactivate' }}
</a>
@endif

@if ($crud->hasAccess('show'))
    <a href="{{ frontendSingleProductURL($entry). '?preview=1' }}"
       target="_blank"
       title="Preview on website"
       class="btn btn-sm btn-link text-capitalize">
        <i class="la la-eye"></i>
        {{ trans('backpack::crud.preview') }}
    </a>
@endif
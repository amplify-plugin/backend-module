@if ($crud->hasAccess('download'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/download') }}" class="btn btn-sm btn-link text-capitalize"><i class="la la-download"></i>{{ __('Download') }}</a>
@endif
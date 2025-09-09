@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Widget' => backpack_url('widget'),
        Route::is('widget.edit') ? 'Edit' : 'Add' => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!!
                    $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('widget.edit') ? 'edit' : 'add')).' '.$crud->entity_name
                    !!}.
            </small>

            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                        <i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <widget-create
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit'
                        : $crud->route.'/create') }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
        method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : 'post'}}"
        query_string="{{ json_encode($query_string) }}"
        widget_data="{{ isset($widgetData) ? json_encode($widgetData) : json_encode([])}}"
        all_templates="{{ json_encode(array_values(config('amplify.cms.themes'))) }}"
        all_placements="{{ json_encode($allPlacements) }}"
        all_page_types="{{ json_encode($allPageTypes) }}"
        all_tags="{{ json_encode($allTags) }}"
        save_action="{{ json_encode($saveAction) }}"
></widget-create>
@endsection

@section('after_scripts')
    <script src="{{  asset("assets/js/app.js") }}"></script>
@endsection

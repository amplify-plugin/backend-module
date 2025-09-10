@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Data Transformations' => backpack_url('data-transformation'),
        Route::is('data-transformation/.edit') ? 'Edit' : 'Add' => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!!
                    $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('data-transformation/.edit') ? 'edit' : 'add')).' '.$crud->entity_name
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
    <data-transformation-create
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
        data_transformation_data="{{ isset($dataTransformationData) ? json_encode($dataTransformationData) : json_encode([]) }}"
        applies_to_options="{{ isset($appliesToOptions) ? json_encode($appliesToOptions) : json_encode([]) }}"
        run_when_options="{{ isset($runWhenOptions) ? json_encode($runWhenOptions) : json_encode([]) }}"
        locale="{{request()->locale ?? 'en'}}"
        available_locales="{{ collect(config('backpack.crud.locales')) }}"
    ></data-transformation-create>
@endsection

@section('after_scripts')
    <script src="{{  mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Template' => backpack_url('template'),
        Route::is('template.edit') ? 'Edit' : 'Add' => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('template.edit') ? 'edit' : (Route::is('page.show') ? 'preview' : 'add'))).' '.$crud->entity_name !!}
                .</small>

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
    <template-create
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit' :
                        ($crud->getCurrentOperation() === 'show' ? $crud->route.'/'.$entry->getKey().'/show'
                        : $crud->route.'/create')) }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
        class_name="{{$crud->getEditContentClass() ?? $crud->getCreateContentClass()}}"
        method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : ($crud->getCurrentOperation() === 'show' ? 'get' : 'post')}}"
        query_string="{{ json_encode($query_string) }}"
        save_action="{{ json_encode($saveAction) }}"
        local_template="{{json_encode($template ?? new \stdClass())}}"
    ></template-create>
@endsection

@section('after_scripts')
    <script src="{{  mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

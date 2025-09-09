@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Page' => backpack_url('page'),
        \Route::is('page.edit') ? 'Edit' : (\Route::is('page.show') ? 'Preview' : 'Add') => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('page.edit') ? 'edit' : (Route::is('page.show') ? 'preview' : 'add'))).' '.$crud->entity_name !!}
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
    <page-create
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit' :
                        ($crud->getCurrentOperation() === 'show' ? $crud->route.'/'.$entry->getKey().'/show'
                        : $crud->route.'/create')) }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update' ? $crud->route.'/'.$entry->getKey() : $crud->route) }}"
        class_name="{{'col-lg-12' }}"
        method="{{$crud->getCurrentOperation() === 'update' ? 'put'  : ($crud->getCurrentOperation() === 'show' ? 'get' : 'post')}}"
        query_string="{{ json_encode($query_string) }}"
        active_template="{{ json_encode(theme()) }}"
        page_types_array="{{ json_encode(config('amplify.cms.page_types')) }}"
        middleware_list="{{ json_encode(array_values(config('amplify.cms.middleware.middlewares'))) }}"
        save_action="{{ json_encode($saveAction) }}"
        :local_page="{{ json_encode($page ?? new \stdClass()) }}"
        :use_right_sidebar="{{ config('amplify.frontend.right_sidebar', true) ? 'true' : 'false' }}"
    ></page-create>

@endsection

@section('after_scripts')
    <script src="{{  asset("assets/js/app.js") }}"></script>
@endsection

@extends(backpack_view('blank'))

@php
$breadcrumbs = [
'Admin' => backpack_url('dashboard'),
'Navigation' => backpack_url('navigation'),
Route::is('navigation.edit') ? 'Edit' : (Route::is('navigation.show') ? 'Preview' : 'Add') => false,
];
parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
<section class="container-fluid">
    <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>
            {!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('navigation.edit') ? 'edit' :
            (Route::is('navigation.show') ? 'preview' : 'add'))).' '.$crud->entity_name !!}
            .</small>

        @if ($crud->hasAccess('list'))
        <small>
            <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                <i
                    class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                {{ trans('backpack::crud.back_to_all') }}
                <span>{{ $crud->entity_name_plural }}</span>
            </a>
        </small>
        @endif
    </h2>
</section>
@endsection

@section('content')
<navigation-create url="{{ url($crud->getCurrentOperation() === 'update'? $crud->route.'/'.$entry->getKey().'/edit' : ($crud->getCurrentOperation() === 'show' ? $crud->route.'/'.$entry->getKey().'/show' : $crud->route.'/create')) }}"
    axios_url="{{ url($crud->getCurrentOperation() === 'update'? $crud->route.'/'.$entry->getKey() : $crud->route) }}"
    class_name="{{'col-lg-12' }}"
    method="{{$crud->getCurrentOperation() === 'update'? 'put' : ($crud->getCurrentOperation() === 'show' ? 'get' : 'post')}}"
    query_string="{{ json_encode($query_string) }}"
    local_navigation="{{json_encode($navigation ?? new \stdClass())}}"
    local_menu_group="{{json_encode($menu_group ?? new \stdClass())}}"
    local_mobile_menu="{{json_encode($mobile_menu ?? new \stdClass())}}"
    local_account_menu="{{json_encode($account_menu ?? new \stdClass())}}"
    save_action="{{ json_encode($saveAction) }}"
    nav_layouts="{{json_encode($nav_layouts) ?? json_encode([])}}"
    menu_list="{{json_encode($menu_list) ?? json_encode([])}}"
>
</navigation-create>
@endsection

@section('after_scripts')
<script src="{{  asset("vendor/backend/js/backend.js") }}"></script>
@endsection

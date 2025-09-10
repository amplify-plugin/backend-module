@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Menu Items' => route('menu.index'),
        'Mega Menu' => $crud->route,
        \Route::is('menu.edit') ? 'Edit' : (\Route::is('menu.show') ? 'Preview' : 'Create') => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('nav-item.edit') ? 'edit' : (Route::is('nav-item.show') ? 'preview' : 'add'))).' '.$crud->entity_name !!}
                .</small>

            @if ($crud->hasAccess('list'))
                <small>
                    <a href='{{ url($crud->route."?menuId=".$menu->id.'&group_id=' . request('group_id')) }}' class="d-print-none font-sm">
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
    <megamenu-create
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit' :
                        ($crud->getCurrentOperation() === 'show' ? $crud->route.'/'.$entry->getKey().'/show'
                        : $crud->route.'/create')) }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
        class_name="{{$crud->getEditContentClass() ?? $crud->getCreateContentClass()}}"
        method="{{ $crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : ($crud->getCurrentOperation() === 'show' ? 'get' : 'post')}}"
        menu="{{ $menu }}"
        mega_menu='@json($mega_menu)'
        mega_menu_types='@json($mega_menu_types)'
        merchandising_zones='@json($merchandising_zones)'
        available_menu_column="{{ $available_menu_column }}"
        categories='@json($categories)'
        category_url="{{ route('mega-menu.category') }}"
    ></megamenu-create>
@endsection

@section('after_scripts')
    <script src="{{  asset("vendor/backend/js/backend.js") }}"></script>
@endsection

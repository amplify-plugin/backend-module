@extends(backpack_view('blank'))

@php
$breadcrumbs = [
    'Admin' => backpack_url('dashboard'),
    'Banner Items' => $crud->route,
    Route::is('menu.edit') ? 'Edit' : (Route::is('menu.show') ? 'Preview' : 'Add') => false,
];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ??
                    trans(
                        'backpack::crud.' . (Route::is('nav-item.edit') ? 'edit' : (Route::is('nav-item.show') ? 'preview' : 'add')),
                    ) .
                        ' ' .
                        $crud->entity_name !!}
                .</small>

        </h2>
    </section>
@endsection

@section('content')
    <banner-create
        method="{{ $crud->getCurrentOperation() === 'update'
            ? 'put'
            : ($crud->getCurrentOperation() === 'show'
                ? 'get'
                : 'post') }}"
        url="{{ url(
            $crud->getCurrentOperation() === 'update'
                ? $crud->route . '/' . $entry->getKey() . '/edit'
                : ($crud->getCurrentOperation() === 'show'
                    ? $crud->route . '/' . $entry->getKey() . '/show'
                    : $crud->route . '/create'),
        ) }}"
        save_action="{{ json_encode($saveAction) }}"
        banner_details='@json($banner_details)'
        axios_url="{{ url($crud->getCurrentOperation() === 'update' ? $crud->route . '/' . $entry->getKey() : $crud->route) }}">
    </banner-create>
@endsection

@section('after_scripts')
    <script src="{{ asset("vendor/backend/js/backend.js") }}"></script>
@endsection

@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Custom Style' => backpack_url('page'),
    ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('page.edit') ? 'edit' : (Route::is('page.show') ? 'preview' : 'add'))).' '.$crud->entity_name !!}
                .</small>
        </h2>
    </section>
@endsection

@section('content')
        <custom-style-editor
            url="#"
            file-path="{{ asset('') }}"/>
@endsection

@section('after_scripts')
    <script src="{{  mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

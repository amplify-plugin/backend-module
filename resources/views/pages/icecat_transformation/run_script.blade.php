@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Data Transformations' => backpack_url('icecat-transformation'),
        'Run Script' => false,
    ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Run icecat transformation : {!! $icecatTransformation->name ?? '' !!}
            </span>
        </h2>
    </section>
@endsection

@section('content')
    <icecat-transformation-run-screen
        easy_ask_default_product_categories="{{ json_encode(eaDefaultCategories('categories')) }}"
        locale="{{ request('locale', 'en') }}"
        transformation_names="{{ isset($transformationNames) ? json_encode($transformationNames) : json_encode([]) }}"
        product_search_by_id_prefix="{{ trim(config('amplify.search.product_search_by_id_prefix')) }}"
        save_action="{{ json_encode($saveAction) }}">
    </icecat-transformation-run-screen>
@endsection

@section('after_scripts')
    <script src="{{ asset("vendor/backend/js/backend.js") }}"></script>
@endsection

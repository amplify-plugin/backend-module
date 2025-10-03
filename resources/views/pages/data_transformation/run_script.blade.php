@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Data Transformations' => backpack_url('data-transformation'),
        'Run Script' => false,
    ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Run data transformation : {!! $dataTransformation->transformation_name ?? '' !!}
</span>
        </h2>
    </section>
@endsection

@section('content')
    <data-transformation-run-screen
            data_transformation_data="{{ isset($dataTransformation) ? json_encode($dataTransformation) : json_encode([]) }}"
            categories="{{ isset($categories) ? json_encode($categories) : json_encode([]) }}"
            easy_ask_default_product_categories="{{ json_encode(eaDefaultCategories('categories')) }}"
            locale="{{request('locale', 'en')}}"
            product_search_by_id_prefix="{{ trim(config('amplify.sayt.product_search_by_id_prefix')) }}"
    ></data-transformation-run-screen>
@endsection

@section('after_scripts')
    <script src="{{  mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Data Transformations' => backpack_url('data-transformation'),
        'Test Script' => false,
    ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Testing data transformation : {!! $dataTransformation->transformation_name ?? '' !!}
</span>
            <small> (Please note that NO data will be changed by running test) </small>
        </h2>
    </section>
@endsection

@section('content')
    <data-transformation-test-screen
        data_transformation_data="{{ isset($dataTransformation) ? json_encode($dataTransformation) : json_encode([]) }}"
        easy_ask_default_product_categories="{{ json_encode(eaDefaultCategories('categories')) }}"
        locale="{{request()->locale ?? 'en'}}"
    ></data-transformation-test-screen>
@endsection

@section('after_scripts')
    <script src="{{  asset("assets/js/app.js") }}"></script>
@endsection

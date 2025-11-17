@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Google Analytics' => true,
    ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{{ __('Google Analytics') }}</span>
            <small></small>
        </h2>
    </section>
@endsection

@section('content')

@endsection

@section('after_scripts')

@endsection

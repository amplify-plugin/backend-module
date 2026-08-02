@extends(backpack_view('blank'))
@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Reports' => false,
        'Adhoc Reports' => false,
    ];
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        </h2>
    </section>
@endsection

@section('content')
    <div id="app">
    <adhoc-report
        api_endpoint="{{ route('dynamic-report.generate-response') }}"
        categories="{{ json_encode($categories) }}"
        fixed_prompts="{{ json_encode($prompts) }}"
        prompt="{{ $prompt }}"
        saved_report="{{ $saved_report? json_encode($saved_report) : null }}"
    ></adhoc-report>
    </div>
@endsection

@section('after_styles')
    <link href="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.0.7/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/fh-4.0.1/r-3.0.2/sb-1.7.1/sp-2.3.1/datatables.min.css" rel="stylesheet">
@endsection

@section('after_scripts')
    <script>
        $(document).ready(function () {
            $(document).on('shown.bs.modal', '.modal', function () {
                $('.modal-backdrop').before($(this));
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.0.7/b-3.0.2/b-colvis-3.0.2/b-html5-3.0.2/b-print-3.0.2/fh-4.0.1/r-3.0.2/sb-1.7.1/sp-2.3.1/datatables.min.js"></script>

    <script src="{{ mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

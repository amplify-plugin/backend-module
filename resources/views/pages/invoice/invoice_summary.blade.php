@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        'Invoice Summary' => request()->url(),
        trans('backpack::crud.list') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="container-fluid">
        <h2 class="mb-4">
            <span class="text-capitalize">Invoice Summary</span>
            <small id="datatable_info_stack">Showing 1 of {{ $invoiceSummary->count() }} entries </small>
            <small>
                <a href="{{ route('invoice.index') }}" class="font-sm">
                    <i class="la la-angle-double-left"></i>
                    Back to all <span>invoices</span>
                </a>
            </small>
        </h2>
    </div>
@endsection

@section('content')
    <div class="row">
        <!-- THE ACTUAL CONTENT -->
        <div class="{{ config('backpack.operations.list.contentClass') }}">
            <div class="row mb-3">
                <div class="col-md-4">
                    <p class="mb-3">Customer: {{ $accountSummary['CustomerName'] ?? 'NA' }}</p>
                </div>

                <div class="col-md-4">
                    <p class="mb-3">Credit Limit: ${{ $accountSummary['CreditLimit'] ?? 'NA' }}</p>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <p>Terms: {{ $accountSummary['TermsDescription'] ?? 'NA' }}</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <p class="mb-3">Last Payment: {{ carbon_date($accountSummary['DateOfLastPayment']) }}</p>
                </div>

                <div class="col-md-4">
                    <p class="mb-3">Amount: ${{ $accountSummary['LastPayAmount'] ?? 'NA' }}</p>
                </div>

                <div class="col-md-4">
                    <p class="mb-3">Open Order Amount: ${{ $accountSummary['OpenOrderAmount'] ?? 'NA' }}</p>
                </div>
            </div>
            <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Invoice Date</th>
                        <th>Customer Ref.</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Detail Available</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoiceSummary ?? [] as $is)
                        <tr>
                            <td>{{ $is['InvoiceNumber'] ?? '' }}</td>
                            <td>{{ carbon_date($is['InvoiceDate']) }}</td>
                            <td>{{ $is['CustomerPONumber'] ?? '' }}</td>
                            <td>${{ $is['InvoiceAmount'] ?? '' }}</td>
                            <td>${{ $is['InvoiceBalance'] ?? '' }}</td>
                            <td class="text-center">
                                {{ $is['HasInvoiceDetail'] ?? 'N/A' }}
                            </td>
                            <td>
                                @if (!empty($is['InvoiceDetail']))
                                    <a class="btn btn-sm btn-link" data-style="zoom-in"
                                        href="{{ url('admin/invoice/invoice-details/' . $is['InvoiceNumber'] . '/' . $customerCode) }}">
                                        <span class="ladda-label"><i class="la la-list"></i> Details </span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Invoice Date</th>
                        <th>Customer Ref.</th>
                        <th>Amount</th>
                        <th>Balance</th>
                        <th>Detail Available</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection

@section('after_styles')
    <!-- DATA TABLES -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('packages/backpack/crud/css/crud.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
    <link rel="stylesheet"
        href="{{ asset('packages/backpack/crud/css/form.css') . '?v=' . config('backpack.base.cachebusting_string') }}">
    <link rel="stylesheet"
        href="{{ asset('packages/backpack/crud/css/list.css') . '?v=' . config('backpack.base.cachebusting_string') }}">

    <!-- CRUD LIST CONTENT - crud_list_styles stack -->
    @stack('crud_list_styles')
@endsection

@section('after_scripts')
    {{-- DATA TABLES SCRIPT --}}
    <script type="text/javascript" src="{{ asset('packages/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('packages/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('packages/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('packages/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('packages/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('packages/datatables.net-fixedheader-bs4/js/fixedHeader.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('packages/backpack/crud/js/crud.js') . '?v=' . config('backpack.base.cachebusting_string') }}">
    </script>
    <script src="{{ asset('packages/backpack/crud/js/form.js') . '?v=' . config('backpack.base.cachebusting_string') }}">
    </script>
    <script src="{{ asset('packages/backpack/crud/js/list.js') . '?v=' . config('backpack.base.cachebusting_string') }}">
    </script>
    <script>
        function getEasyAskDefaultImage(event) {
            event.target.src = '{{ asset(config('amplify.frontend.fallback_image_path')) }}';
            event.onerror = null
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {

            $('#crudTable').DataTable();
        });
    </script>
@endsection

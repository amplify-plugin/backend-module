@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Exports' => backpack_url('export'),
        'Workspace' => false,
    ];

    $selectedProductColumns = old('columns', $defaultSelectedColumns ?? []);
    $selectedManufacturerColumns = old('manufacturer_columns', $defaultManufacturerSelectedColumns ?? []);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">Exports Workspace</span>
            <small>Switch between export and import helpers without leaving the page.</small>
        </h2>
    </section>
@endsection

@section('content')
    <div class="card border-0 shadow-xs">
        <div class="card-body">
            <ul class="nav nav-tabs" id="export-workspace-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="product-export-tab" data-toggle="tab" href="#product-export-pane" role="tab">
                        Product Export
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="manufacturer-export-tab" data-toggle="tab" href="#manufacturer-export-pane" role="tab">
                        Manufacturer Export
                    </a>
                </li>
            </ul>

            <div class="tab-content pt-4">
                <div class="tab-pane fade show active" id="product-export-pane" role="tabpanel">
                    <form method="POST" action="{{ route('admin.export.products.download') }}" id="product-export-form">
                        @csrf
                        <input type="hidden" name="locale" value="{{ app()->getLocale() }}">

                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <div class="border rounded p-3 mb-3 h-100">
                                    <h4 class="mb-2">Conditions</h4>
                                    <p class="text-muted mb-3">Filter the products before exporting.</p>

                                    @foreach($productExportConditions as $conditionKey => $condition)
                                        <div class="form-group mb-3">
                                            <label for="{{ $conditionKey }}">{{ $condition['label'] }}</label>
                                            <select name="{{ $conditionKey }}" id="{{ $conditionKey }}" class="form-control">
                                                @foreach($condition['options'] as $optionValue => $optionLabel)
                                                    <option
                                                        value="{{ $optionValue }}"
                                                        {{ request($conditionKey, $selectedProductConditions[$conditionKey] ?? 'any') === $optionValue ? 'selected' : '' }}
                                                    >
                                                        {{ $optionLabel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach

                                    <div class="small text-muted">
                                        Use the brand and manufacturer filters to export only matching products.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <div class="border rounded p-3 mb-3 h-100">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h4 class="mb-1">Select columns</h4>
                                            <p class="text-muted mb-0">{{ $productCount ?? 0 }} products available</p>
                                        </div>
                                        <a href="javascript:void(0)" class="btn btn-link btn-sm p-0" data-select-all="product">Select all</a>
                                    </div>

                                    <div class="border rounded p-3" style="max-height: 520px; overflow-y: auto;">
                                        @foreach($productExportColumns as $columnKey => $column)
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input
                                                    class="custom-control-input export-column export-column-product"
                                                    type="checkbox"
                                                    id="product-export-column-{{ $columnKey }}"
                                                    name="columns[]"
                                                    value="{{ $columnKey }}"
                                                    {{ in_array($columnKey, $selectedProductColumns, true) ? 'checked' : '' }}
                                                >
                                                <label class="custom-control-label" for="product-export-column-{{ $columnKey }}">
                                                    <span class="d-block">{{ $column['label'] }}</span>
                                                    <small class="text-muted">{{ $columnKey }}</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="d-flex mt-3">
                                        <button type="submit" class="btn btn-primary mr-2">Download CSV</button>
                                        <a href="{{ backpack_url('export') }}" class="btn btn-light">Reset</a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <div class="border rounded p-3 h-100">
                                    <h4 class="mb-3">What gets exported</h4>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 220px;">Column</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($productExportColumns as $columnKey => $column)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $column['label'] }}</strong>
                                                            @if(!empty($column['selected_by_default']))
                                                                <span class="badge badge-success ml-2">Default</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $columnKey }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="manufacturer-export-pane" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-4 col-md-5">
                            <div class="border rounded p-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h4 class="mb-1">Select columns</h4>
                                        <p class="text-muted mb-0">{{ $manufacturerCount ?? 0 }} manufacturers available</p>
                                    </div>
                                    <a href="javascript:void(0)" class="btn btn-link btn-sm p-0" data-select-all="manufacturer">Select all</a>
                                </div>

                                <form method="POST" action="{{ route('admin.export.manufacturers.download') }}" id="manufacturer-export-form">
                                    @csrf

                                    <div class="border rounded p-3" style="max-height: 520px; overflow-y: auto;">
                                        @foreach($manufacturerExportColumns as $columnKey => $column)
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input
                                                    class="custom-control-input export-column export-column-manufacturer"
                                                    type="checkbox"
                                                    id="manufacturer-export-column-{{ $columnKey }}"
                                                    name="columns[]"
                                                    value="{{ $columnKey }}"
                                                    {{ in_array($columnKey, $selectedManufacturerColumns, true) ? 'checked' : '' }}
                                                >
                                                <label class="custom-control-label" for="manufacturer-export-column-{{ $columnKey }}">
                                                    <span class="d-block">{{ $column['label'] }}</span>
                                                    <small class="text-muted">{{ $columnKey }}</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="d-flex mt-3">
                                        <button type="submit" class="btn btn-primary mr-2">Download CSV</button>
                                        <a href="{{ backpack_url('export') }}" class="btn btn-light">Reset</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-8 col-md-7">
                            <div class="border rounded p-3">
                                <h4 class="mb-3">What gets exported</h4>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th style="width: 220px;">Column</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($manufacturerExportColumns as $columnKey => $column)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $column['label'] }}</strong>
                                                        @if(!empty($column['selected_by_default']))
                                                            <span class="badge badge-success ml-2">Default</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $columnKey }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        .card.shadow-xs {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection

@section('after_scripts')
    <script src="{{ mix('js/backend.js', 'vendor/backend') }}"></script>
    <script>
        (function () {
            const tabTriggers = document.querySelectorAll('[data-select-all]');

            tabTriggers.forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    const type = trigger.getAttribute('data-select-all');
                    document.querySelectorAll('.export-column-' + type).forEach(function (checkbox) {
                        checkbox.checked = true;
                    });
                });
            });
        })();
    </script>
@endsection

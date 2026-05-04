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
                    <a class="nav-link" id="product-export-tab" data-toggle="tab" href="#product-export-pane" role="tab">
                        Product Export
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="manufacturer-export-tab" data-toggle="tab" href="#manufacturer-export-pane" role="tab">
                        Manufacturer Export
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="sql-export-tab" data-toggle="tab" href="#sql-export-pane" role="tab">
                        {{ __('SQL Export') }}
                    </a>
                </li>
            </ul>

            <div class="tab-content pt-4">
                <div class="tab-pane fade" id="product-export-pane" role="tabpanel">
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

                <div class="tab-pane fade show active" id="sql-export-pane" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="border rounded p-3 mb-3">
                                <h4 class="mb-2">{{ __('Write SQL') }}</h4>
                                <p class="text-muted mb-3">{{ __('Only SELECT query is supported. Insert, update, delete, and other statements are not allowed.') }}</p>

                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group mb-3">
                                            <label for="sql-history-label">{{ __('History Label') }}</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="sql-history-label"
                                                maxlength="120"
                                                placeholder="{{ __('Optional label. Random label will be used if empty.') }}"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group mb-3">
                                            <label for="sql-preview-limit">{{ __('Preview Count') }}</label>
                                            <input
                                                type="number"
                                                class="form-control"
                                                id="sql-preview-limit"
                                                min="1"
                                                max="100"
                                                value="10"
                                            >
                                            <small class="text-muted">{{ __('Maximum 100 rows.') }}</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sql-export-limit">{{ __('Export Row Limit') }}</label>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="sql-export-limit"
                                        min="1"
                                        max="1000000"
                                        value="100000"
                                    >
                                    <small class="text-muted">{{ __('Maximum 1000000 rows per request.') }}</small>
                                </div>

                                <div class="form-group mb-3">
                                    <textarea
                                        class="form-control"
                                        id="sql-export-editor"
                                        rows="12"
                                        placeholder="{{ __('Example: SELECT id, product_name FROM products WHERE status = \"published\" LIMIT 100;') }}"
                                    ></textarea>
                                </div>

                                <div class="d-flex align-items-center">
                                    <button type="button" class="btn btn-primary mr-2" id="sql-preview-btn">{{ __('Check SQL') }}</button>
                                    <button type="button" class="btn btn-light mr-2" id="sql-clear-btn">{{ __('Clear') }}</button>
                                    <button type="button" class="btn btn-success" id="sql-download-btn" disabled>{{ __('Download CSV') }}</button>
                                </div>
                                <form method="POST" action="{{ route('admin.export.sql.download') }}" id="sql-export-form" class="d-none">
                                    @csrf
                                    <input type="hidden" name="sql" id="sql-export-hidden-query" value="">
                                    <input type="hidden" name="export_limit" id="sql-export-hidden-limit" value="100000">
                                </form>

                                <div class="mt-3">
                                    <span class="badge badge-secondary" id="sql-status-badge">{{ __('Not checked') }}</span>
                                    <small class="d-block text-muted mt-2" id="sql-status-message"></small>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12">
                            <div class="border rounded p-3">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h4 class="mb-0">{{ __('SQL History') }}</h4>
                                    <button type="button" class="btn btn-link btn-sm p-0" id="sql-history-refresh-btn">{{ __('Refresh') }}</button>
                                </div>
                                <small class="d-block text-muted mb-3">{{ __('Reuse a previous valid query or remove it from history.') }}</small>
                                <div id="sql-history-list" class="sql-history-list"></div>
                                <div class="d-flex align-items-center justify-content-between mt-3" id="sql-history-pagination" style="display: none !important;">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="sql-history-prev-btn">{{ __('Previous') }}</button>
                                    <small class="text-muted" id="sql-history-page-info"></small>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="sql-history-next-btn">{{ __('Next') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="border rounded p-3">
                                <h4 class="mb-3">{{ __('Preview') }}</h4>
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped mb-0" id="sql-preview-table">
                                        <thead id="sql-preview-head"></thead>
                                        <tbody id="sql-preview-body">
                                            <tr>
                                                <td class="text-muted">{{ __('No preview data yet.') }}</td>
                                            </tr>
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

        #sql-export-editor {
            font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
            font-size: 0.9rem;
        }

        .sql-history-list .sql-history-item {
            border: 1px solid #e9ecef;
            border-radius: 0.25rem;
            padding: 0.65rem;
            margin-bottom: 0.6rem;
        }

        .sql-history-list .sql-history-query {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
            font-size: 0.8rem;
        }
    </style>
@endsection

@section('after_scripts')
    <script src="{{ mix('js/backend.js', 'vendor/backend') }}"></script>
    <script>
        (function () {
            const tabTriggers = document.querySelectorAll('[data-select-all]');
            const sqlPreviewButton = document.getElementById('sql-preview-btn');
            const sqlClearButton = document.getElementById('sql-clear-btn');
            const sqlForm = document.getElementById('sql-export-form');
            const sqlEditor = document.getElementById('sql-export-editor');
            const sqlHistoryLabel = document.getElementById('sql-history-label');
            const sqlPreviewLimit = document.getElementById('sql-preview-limit');
            const sqlExportLimit = document.getElementById('sql-export-limit');
            const sqlStatusBadge = document.getElementById('sql-status-badge');
            const sqlStatusMessage = document.getElementById('sql-status-message');
            const sqlDownloadButton = document.getElementById('sql-download-btn');
            const sqlHiddenQuery = document.getElementById('sql-export-hidden-query');
            const sqlHiddenLimit = document.getElementById('sql-export-hidden-limit');
            const sqlPreviewHead = document.getElementById('sql-preview-head');
            const sqlPreviewBody = document.getElementById('sql-preview-body');
            const sqlHistoryList = document.getElementById('sql-history-list');
            const sqlHistoryRefreshButton = document.getElementById('sql-history-refresh-btn');
            const sqlHistoryPagination = document.getElementById('sql-history-pagination');
            const sqlHistoryPrevButton = document.getElementById('sql-history-prev-btn');
            const sqlHistoryNextButton = document.getElementById('sql-history-next-btn');
            const sqlHistoryPageInfo = document.getElementById('sql-history-page-info');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            let sqlHistoryCurrentPage = 1;
            let sqlHistoryLastPage = 1;

            tabTriggers.forEach(function (trigger) {
                trigger.addEventListener('click', function () {
                    const type = trigger.getAttribute('data-select-all');
                    document.querySelectorAll('.export-column-' + type).forEach(function (checkbox) {
                        checkbox.checked = true;
                    });
                });
            });

            function setSqlStatus(state, message) {
                sqlStatusBadge.classList.remove('badge-secondary', 'badge-success', 'badge-danger', 'badge-warning');
                if (state === 'valid') {
                    sqlStatusBadge.classList.add('badge-success');
                    sqlStatusBadge.textContent = '{{ __('Valid') }}';
                } else if (state === 'invalid') {
                    sqlStatusBadge.classList.add('badge-danger');
                    sqlStatusBadge.textContent = '{{ __('Invalid') }}';
                } else if (state === 'loading') {
                    sqlStatusBadge.classList.add('badge-warning');
                    sqlStatusBadge.textContent = '{{ __('Checking') }}';
                } else {
                    sqlStatusBadge.classList.add('badge-secondary');
                    sqlStatusBadge.textContent = '{{ __('Not checked') }}';
                }

                sqlStatusMessage.classList.remove('text-danger', 'text-muted');
                sqlStatusMessage.classList.add(state === 'invalid' ? 'text-danger' : 'text-muted');
                sqlStatusMessage.textContent = message || '';
            }

            function disableSqlExport() {
                if (sqlDownloadButton) {
                    sqlDownloadButton.disabled = true;
                }
                if (sqlHiddenQuery) {
                    sqlHiddenQuery.value = '';
                }
            }

            function escapeHtml(value) {
                return String(value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function renderSqlHistory(items, meta) {
                if (!sqlHistoryList) {
                    return;
                }

                if (!items || items.length === 0) {
                    sqlHistoryList.innerHTML = '<div class="text-muted small">{{ __('No SQL history yet.') }}</div>';
                    if (sqlHistoryPagination) {
                        sqlHistoryPagination.style.display = 'none';
                    }
                    return;
                }

                sqlHistoryList.innerHTML = items.map(function (item) {
                    return ''
                        + '<div class="sql-history-item" data-history-id="' + item.id + '">'
                        + '  <div class="small text-muted mb-1">' + escapeHtml(item.name || '-') + '</div>'
                        + '  <div class="sql-history-query mb-2" title="' + escapeHtml(item.query) + '">' + escapeHtml(item.query) + '</div>'
                        + '  <div class="d-flex justify-content-between align-items-center">'
                        + '      <small class="text-muted">{{ __('Last used') }}: ' + escapeHtml(item.last_used_at || '-') + '</small>'
                        + '      <div>'
                        + '          <button type="button" class="btn btn-sm btn-outline-primary mr-1" data-history-action="use">{{ __('Use') }}</button>'
                        + '          <button type="button" class="btn btn-sm btn-outline-danger" data-history-action="delete">{{ __('Remove') }}</button>'
                        + '      </div>'
                        + '  </div>'
                        + '</div>';
                }).join('');

                if (sqlHistoryPagination && meta) {
                    sqlHistoryCurrentPage = meta.current_page || 1;
                    sqlHistoryLastPage = meta.last_page || 1;
                    sqlHistoryPagination.style.display = 'flex';
                    sqlHistoryPrevButton.disabled = sqlHistoryCurrentPage <= 1;
                    sqlHistoryNextButton.disabled = sqlHistoryCurrentPage >= sqlHistoryLastPage;
                    sqlHistoryPageInfo.textContent = '{{ __('Page') }} ' + sqlHistoryCurrentPage + ' {{ __('of') }} ' + sqlHistoryLastPage;
                }
            }

            function loadSqlHistory(page) {
                if (!sqlHistoryList) {
                    return;
                }

                const requestedPage = page || 1;
                fetch('{{ route('admin.export.sql.history') }}?page=' + requestedPage + '&per_page=4', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                    .then(async function (response) {
                        const payload = await response.json();
                        if (!response.ok) {
                            throw new Error('{{ __('Failed to load SQL history.') }}');
                        }
                        renderSqlHistory(payload.items || [], payload.meta || null);
                    })
                    .catch(function () {
                        sqlHistoryList.innerHTML = '<div class="text-danger small">{{ __('Could not load SQL history.') }}</div>';
                    });
            }

            function renderSqlPreview(columns, rows) {
                sqlPreviewHead.innerHTML = '';
                sqlPreviewBody.innerHTML = '';

                if (!rows || rows.length === 0) {
                    sqlPreviewBody.innerHTML = '<tr><td class="text-muted">{{ __('Query is valid but no rows found.') }}</td></tr>';
                    return;
                }

                const headerRow = document.createElement('tr');
                columns.forEach(function (column) {
                    const th = document.createElement('th');
                    th.textContent = column;
                    headerRow.appendChild(th);
                });
                sqlPreviewHead.appendChild(headerRow);

                rows.forEach(function (row) {
                    const tr = document.createElement('tr');
                    columns.forEach(function (column) {
                        const td = document.createElement('td');
                        td.textContent = row[column] === null ? '' : String(row[column]);
                        tr.appendChild(td);
                    });
                    sqlPreviewBody.appendChild(tr);
                });
            }

            if (sqlEditor) {
                sqlEditor.addEventListener('input', function () {
                    setSqlStatus('idle', '{{ __('Please re-check SQL after making changes.') }}');
                    disableSqlExport();
                });
            }

            if (sqlPreviewButton) {
                sqlPreviewButton.addEventListener('click', function () {
                    const sql = (sqlEditor.value || '').trim();
                    if (!sql) {
                        setSqlStatus('invalid', '{{ __('Please write a SQL query first.') }}');
                        disableSqlExport();
                        return;
                    }

                    let previewLimit = parseInt((sqlPreviewLimit?.value || '10'), 10);
                    if (Number.isNaN(previewLimit) || previewLimit < 1) {
                        previewLimit = 1;
                    }
                    if (previewLimit > 100) {
                        previewLimit = 100;
                    }
                    if (sqlPreviewLimit) {
                        sqlPreviewLimit.value = String(previewLimit);
                    }

                    setSqlStatus('loading', '{{ __('Validating SQL and loading preview...') }}');
                    disableSqlExport();
                    const historyLabelValue = sqlHistoryLabel ? sqlHistoryLabel.value : '';
                    fetch('{{ route('admin.export.sql.preview') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            sql: sql,
                            label: historyLabelValue.trim(),
                            limit: previewLimit
                        })
                    })
                        .then(async function (response) {
                            const payload = await response.json();
                            if (!response.ok || !payload.valid) {
                                throw new Error(payload.message || '{{ __('Invalid SQL query.') }}');
                            }

                            setSqlStatus('valid', payload.message || '{{ __('SQL is valid.') }}');
                            renderSqlPreview(payload.columns || [], payload.rows || []);
                            if (sqlHiddenQuery) {
                                sqlHiddenQuery.value = sql;
                            }
                            if (sqlHiddenLimit) {
                                let exportLimit = parseInt((sqlExportLimit?.value || '100000'), 10);
                                if (Number.isNaN(exportLimit) || exportLimit < 1) {
                                    exportLimit = 1;
                                }
                                if (exportLimit > 1000000) {
                                    exportLimit = 1000000;
                                }
                                if (sqlExportLimit) {
                                    sqlExportLimit.value = String(exportLimit);
                                }
                                sqlHiddenLimit.value = String(exportLimit);
                            }
                            if (sqlDownloadButton) {
                                sqlDownloadButton.disabled = false;
                            }
                            loadSqlHistory(1);
                        })
                        .catch(function (error) {
                            setSqlStatus('invalid', error.message || '{{ __('Invalid SQL query.') }}');
                            sqlPreviewHead.innerHTML = '';
                            sqlPreviewBody.innerHTML = '<tr><td class="text-muted">{{ __('No preview data yet.') }}</td></tr>';
                            disableSqlExport();
                        });
                });
            }

            if (sqlClearButton) {
                sqlClearButton.addEventListener('click', function () {
                    sqlEditor.value = '';
                    if (sqlHistoryLabel) {
                        sqlHistoryLabel.value = '';
                    }
                    setSqlStatus('idle', '');
                    disableSqlExport();
                    sqlPreviewHead.innerHTML = '';
                    sqlPreviewBody.innerHTML = '<tr><td class="text-muted">{{ __('No preview data yet.') }}</td></tr>';
                });
            }

            if (sqlDownloadButton && sqlForm) {
                sqlDownloadButton.addEventListener('click', function () {
                    if (!sqlDownloadButton.disabled) {
                        sqlForm.submit();
                    }
                });
            }

            if (sqlHistoryRefreshButton) {
                sqlHistoryRefreshButton.addEventListener('click', function () {
                    loadSqlHistory(sqlHistoryCurrentPage);
                });
            }

            if (sqlHistoryPrevButton) {
                sqlHistoryPrevButton.addEventListener('click', function () {
                    if (sqlHistoryCurrentPage > 1) {
                        loadSqlHistory(sqlHistoryCurrentPage - 1);
                    }
                });
            }

            if (sqlHistoryNextButton) {
                sqlHistoryNextButton.addEventListener('click', function () {
                    if (sqlHistoryCurrentPage < sqlHistoryLastPage) {
                        loadSqlHistory(sqlHistoryCurrentPage + 1);
                    }
                });
            }

            if (sqlHistoryList) {
                sqlHistoryList.addEventListener('click', function (event) {
                    const target = event.target;
                    if (!(target instanceof HTMLElement)) {
                        return;
                    }

                    const action = target.getAttribute('data-history-action');
                    if (!action) {
                        return;
                    }

                    const item = target.closest('.sql-history-item');
                    if (!item) {
                        return;
                    }

                    const historyId = item.getAttribute('data-history-id');
                    if (!historyId) {
                        return;
                    }

                    if (action === 'use') {
                        const queryElement = item.querySelector('.sql-history-query');
                        if (sqlEditor) {
                            sqlEditor.value = queryElement ? queryElement.textContent : '';
                        }
                        const labelElement = item.querySelector('.small.text-muted.mb-1');
                        if (sqlHistoryLabel && labelElement) {
                            sqlHistoryLabel.value = labelElement.textContent || '';
                        }
                        setSqlStatus('idle', '{{ __('Loaded from history. Click Check SQL.') }}');
                        disableSqlExport();
                        return;
                    }

                    if (action === 'delete') {
                        fetch('{{ url(config('backpack.base.route_prefix').'/export/sql/history') }}/' + historyId, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        })
                            .then(async function (response) {
                                const payload = await response.json();
                                if (!response.ok || !payload.success) {
                                    throw new Error(payload.message || '{{ __('Could not remove query.') }}');
                                }
                                const nextPage = (sqlHistoryCurrentPage > 1 && sqlHistoryList.children.length === 1)
                                    ? sqlHistoryCurrentPage - 1
                                    : sqlHistoryCurrentPage;
                                loadSqlHistory(nextPage);
                            })
                            .catch(function () {
                            });
                    }
                });
            }

            loadSqlHistory(1);
        })();
    </script>
@endsection

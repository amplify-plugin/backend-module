@php
    use Amplify\Frontend\Services\TopSellingProductsService;

    /** @var TopSellingProductsService $service */
    $service = app(TopSellingProductsService::class);
@endphp

@if ($service->isEnabled())
    @php
        $rows = $service->getTopSellingProductStats();
        $dateRangeLabel = $service->dateRangeLabel();
    @endphp

    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            <span class="font-weight-bold">{{ __('Top Selling Products') }}</span>
            <span class="text-muted small">{{ __($dateRangeLabel) }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered mb-0"
                       id="admin-top-selling-products-table"
                       style="width:100%">
                    <thead>
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Product Code') }}</th>
                            <th>{{ __('Unit') }}</th>
                            <th class="text-right">{{ __('Units Sold') }}</th>
                            <th class="text-right">{{ __('Revenue') }}</th>
                            <th class="text-right">{{ __('Orders') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $row)
                            <tr>
                                <td>{{ $row->product_name ?: $row->product_code }}</td>
                                <td>{{ $row->product_code }}</td>
                                <td>{{ $row->unit_code ?: '—' }}</td>
                                <td class="text-right"
                                    data-order="{{ $row->units_sold }}">
                                    {{ rtrim(rtrim(number_format((float) $row->units_sold, 2, '.', ','), '0'), '.') }}
                                </td>
                                <td class="text-right" data-order="{{ $row->revenue }}">
                                    {{ price_format($row->revenue) }}
                                </td>
                                <td class="text-right" data-order="{{ $row->order_count }}">
                                    {{ $row->order_count }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    {{ __('No selling products found for this period.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if ($rows->isNotEmpty())
        @push('after_styles')
            <link rel="stylesheet" type="text/css"
                  href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
            <link rel="stylesheet" type="text/css"
                  href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
        @endpush

        @push('after_scripts')
            <script src="{{ asset('packages/datatables.net/js/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('packages/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
            <script src="{{ asset('packages/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
            <script src="{{ asset('packages/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
            <script>
                jQuery(function ($) {
                    var $table = $('#admin-top-selling-products-table');

                    if (!$table.length || typeof $.fn.DataTable === 'undefined') {
                        return;
                    }

                    if ($.fn.DataTable.isDataTable($table)) {
                        return;
                    }

                    $table.DataTable({
                        order: [[4, 'desc']],
                        pageLength: 10,
                        lengthMenu: [[5, 10, 20, 50, -1], [5, 10, 20, 50, 'All']],
                        responsive: true,
                        autoWidth: false,
                        language: {
                            search: '{{ __('Filter') }}:',
                            lengthMenu: '{{ __('Show _MENU_ entries') }}',
                            info: '{{ __('Showing _START_ to _END_ of _TOTAL_ products') }}',
                            zeroRecords: '{{ __('No matching products found') }}'
                        }
                    });
                });
            </script>
        @endpush
    @endif
@endif

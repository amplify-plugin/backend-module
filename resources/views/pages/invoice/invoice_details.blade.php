@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      'Invoice Details' => request()->url(),
      trans('backpack::crud.list') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="container-fluid">
        <h2 class="mb-4">
            <span class="text-capitalize">Invoice Details</span>
            <small>
                <a href="{{ url('admin/invoice/invoice-summary/'. $customerCode) }}" class="font-sm">
                    <i class="la la-angle-double-left"></i>
                    Back to all <span>invoice summary</span>
                </a>
            </small>
        </h2>
    </div>
@endsection

@php
    $invoiceDetails = $invoice->InvoiceDetail->first();
@endphp

@section('content')
    <div class="row">
        <div class="{{config('backpack.operations.list.contentClass')}}">
            <dvi class="card">
                <div class="card-body px-5">
                    <div class="row justify-content-end">
                        @if($invoiceDetails)
                            <div class="col-md-12 mt-2 border p-2">
                                <span>Name: {{ $invoiceDetails['OrderSuffix'] ?? '' }}</span> <br>
                                <span>Date: {{ $invoiceDetails['EntryDate'] ?? '' }}</span>
                            </div>

                            <div class="col-md-12 d-flex justify-content-between align-items-center border p-2">
                                <div class="col-md-3 border-right">
                                    Bill To: <br>
                                    {{ $invoiceDetails['CustomerNumber'] ?? '' }}
                                </div>
                                <div class="col-md-3 border-right">
                                    {{ $invoiceDetails['CustomerName'] ?? '' }} <br>
                                    {{ $invoiceDetails['CustomerAddress1'] ?? '' }} <br>
                                    {{ $invoiceDetails['ShipToCity'] ?? '' }} {{ $invoiceDetails['ShipToState'] ?? '' }} {{ $invoiceDetails['BillToZipCode'] ?? '' }}
                                </div>
                                <div class="col-md-3 border-right">
                                    Ship To: <br>
                                    {{ $invoiceDetails['ShipToNumber'] ?? '' }}
                                </div>
                                <div class="col-md-3">
                                    {{ $invoiceDetails['CustomerName'] ?? '' }} <br>
                                    {{ $invoiceDetails['CustomerAddress1'] ?? '' }} <br>
                                    {{ $invoiceDetails['ShipToCity'] ?? '' }} {{ $invoiceDetails['ShipToState'] ?? '' }} {{ $invoiceDetails['BillToZipCode'] ?? '' }}
                                </div>
                            </div>

                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th>Reference #</th>
                                    <th>Shipped</th>
                                    <th>Terms</th>
                                    <th>Tax Code</th>
                                    <th>Doc #</th>
                                    <th>Wh</th>
                                    <th>Freight</th>
                                    <th>Ship Via</th>
                                </tr>
                                <tr>
                                    <td>{{ $invoiceDetails['CustomerPurchaseOrdernumber'] ?? '' }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $invoiceDetails['OrderNumber'] ?? '' }}</td>
                                    <td>{{ $invoiceDetails['WarehouseID'] ?? '' }}</td>
                                    <td></td>
                                    <td>{{ $invoiceDetails['CarrierCode'] ?? '' }}</td>
                                </tr>
                            </table>

                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th>Ordered</th>
                                    <th>Shipped</th>
                                    <th>Backordered</th>
                                    <th>Price</th>
                                    <th>Extension</th>
                                </tr>

                                @forelse (($invoiceDetails['OrderDetail'] ?? []) as $is)
                                    <tr>
                                        <td>{{ $is['ItemNumber'] ?? '' }}</td>
                                        <td>{{ $is['ItemDescription1'] ?? '' }}</td>
                                        <td>{{ $is['QuantityOrdered'] ?? '' }}</td>
                                        <td>{{ $is['QuantityShipped'] ?? '' }}</td>
                                        <td>{{ $is['QuantityBackordered'] ?? '' }}</td>
                                        <td>{{ $is['ActualSellPrice'] ?? '' }}</td>
                                        <td>${{ $is['TotalLineAmount'] ?? '' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <div class="alert alert-danger">
                                                <strong>{{ __('No Details Found!') }}</strong>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse

                            </table>

                            <table class="table table-bordered w-50 float-right">
                                <tr>
                                    <th>Merchandise</th>
                                    <th>Misc</th>
                                    <th>Discount</th>
                                    <th>Tax</th>
                                    <th>Freight</th>
                                    <th>Total Due</th>
                                </tr>

                                <tr>
                                    <td> ${{ $invoiceDetails['InvoiceAmount'] ?? '' }}</td>
                                    <td></td>
                                    <td> ${{ $invoiceDetails['DiscountAmountTrading'] ?? '' }}</td>
                                    <td> ${{ $invoiceDetails['SalesTaxAmount'] ?? '' }}</td>
                                    <td> ${{ $invoiceDetails['FreightAmount'] ?? '' }}</td>
                                    @php
                                        $invoiceAmount = (float) preg_replace('/[^0-9.]/', '', ($invoiceDetails['InvoiceAmount'] ?? '0.0'));
                                        $taxAmount = (float) preg_replace('/[^0-9.]/', '', ($invoiceDetails['SalesTaxAmount'] ?? '0.0'));
                                        $freightAmount = (float) preg_replace('/[^0-9.]/', '', ($invoiceDetails['FreightAmount'] ?? '0.0'));
                                        $discountAmount = (float) preg_replace('/[^0-9.]/', '', ($invoiceDetails['DiscountAmountTrading'] ?? '0.0'));

                                        $totalAmount = $invoiceAmount + $taxAmount + $freightAmount - $discountAmount;
                                    @endphp
                                    <td>{{ currency_format($totalAmount, null, true) }}</td>
                                </tr>
                            </table>
                        @else
                            <div class="col-md-12 mt-2 border p-2">
                                <h3 class="text-white bg-danger">Invoice data does not exists !</h3>
                            </div>
                        @endif
                    </div>
                </div>
            </dvi>
        </div>
    </div>
@endsection

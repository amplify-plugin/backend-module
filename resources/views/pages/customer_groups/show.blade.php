@extends(backpack_view('blank'))

@php
    $group = $customer_group_data ?? $entry ?? null;
    $groupId = $group?->id;
    $groupName = $group?->group_name ?? 'Customer Group';
    $pricingRules = $group?->cg_pricing_rules;
    $pricingTypeLabel = \Amplify\System\Backend\Models\CustomerGroup::CUSTOMER_GROUP_PRICING_TYPE[$group?->group_pricing_type ?? ''] ?? ($group?->group_pricing_type ?? '-');

    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Customer Groups' => backpack_url('customer-group'),
        ($groupName ?? 'Details') => false,
    ];
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        <div class="d-flex align-items-start justify-content-between flex-wrap gap-2">
            <div>
                <h2 class="mb-1">
                    <span class="text-capitalize">{{ $groupName }}</span>
                    <small class="d-block mt-1">
                        Customer group details and relations
                    </small>
                </h2>
            </div>

            <div class="btn-group">
                @if ($crud->hasAccess('list'))
                    <a href="{{ url($crud->route) }}" class="btn btn-light">
                        <i class="la la-angle-left"></i>
                        Back to list
                    </a>
                @endif
                @if ($crud->hasAccess('update') && $group)
                    <a href="{{ url($crud->route.'/'.$groupId.'/edit') }}" class="btn btn-primary">
                        <i class="la la-edit"></i>
                        Edit
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getShowContentClass() ?? 'col-md-12' }}">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="small text-muted text-uppercase">Group Code</div>
                            <div class="h5 mb-0">{{ $group?->group_code ?? '-' }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="small text-muted text-uppercase">Group Name</div>
                            <div class="h5 mb-0">{{ $group?->group_name ?? '-' }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="small text-muted text-uppercase">Pricing Type</div>
                            <div class="h5 mb-0">{{ $pricingTypeLabel }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="small text-muted text-uppercase">Relations</div>
                            <div class="h5 mb-0">
                                <span class="badge badge-info mr-1">{{ $group?->customers?->count() ?? 0 }} Customers</span>
                                <span class="badge badge-secondary mr-1">{{ $group?->users?->count() ?? 0 }} Users</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white">
                            <strong>Assigned Users</strong>
                        </div>
                        <div class="card-body">
                            @if ($group && $group->users->count())
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($group->users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-muted">No users are assigned to this group.</div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <strong>Assigned Customers</strong>
                            <span class="badge badge-light">{{ $group?->customers?->count() ?? 0 }}</span>
                        </div>
                        <div class="card-body">
                            @if ($group && $group->customers->count())
                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($group->customers as $customer)
                                            <tr>
                                                <td>{{ $customer->customer_code }}</td>
                                                <td>{{ $customer->customer_name }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->phone }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-muted">No customers are assigned to this group.</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white">
                    <strong>Pricing Rules</strong>
                </div>
                <div class="card-body">
                    @if (! $pricingRules)
                        <div class="alert alert-light border mb-0">
                            No pricing rules have been configured for this group.
                        </div>
                    @else
                        <div class="row mb-4">
                            <div class="col-md-3 mb-2">
                                <div class="small text-muted text-uppercase">Flat Discount</div>
                                <span class="badge badge-{{ $pricingRules->is_flat_discount ? 'success' : 'secondary' }}">
                                    {{ $pricingRules->is_flat_discount ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                            <div class="col-md-3 mb-2">
                                <div class="small text-muted text-uppercase">Volume Discount</div>
                                <span class="badge badge-{{ $pricingRules->is_volume_discount ? 'success' : 'secondary' }}">
                                    {{ $pricingRules->is_volume_discount ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                            <div class="col-md-3 mb-2">
                                <div class="small text-muted text-uppercase">Volume Additive</div>
                                <span class="badge badge-{{ $pricingRules->is_volume_discount_additive ? 'success' : 'secondary' }}">
                                    {{ $pricingRules->is_volume_discount_additive ? 'Yes' : 'No' }}
                                </span>
                            </div>
                            <div class="col-md-3 mb-2">
                                <div class="small text-muted text-uppercase">Order Value Discount</div>
                                <span class="badge badge-{{ $pricingRules->is_order_value_discount ? 'success' : 'secondary' }}">
                                    {{ $pricingRules->is_order_value_discount ? 'Enabled' : 'Disabled' }}
                                </span>
                            </div>
                        </div>

                        @if ($pricingRules->is_flat_discount)
                            <div class="mb-4">
                                <h5 class="mb-3">Flat Discount Levels</h5>
                                @if ($pricingRules->flat_discounts->count())
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="thead-light">
                                            <tr>
                                                <th style="width: 120px;">Discount %</th>
                                                <th>Categories</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($pricingRules->flat_discounts as $flatDiscount)
                                                <tr>
                                                    <td>{{ $flatDiscount->discount }}</td>
                                                    <td>
                                                        @if ($flatDiscount->categories->count())
                                                            {{ $flatDiscount->categories->pluck('category_name')->implode(', ') }}
                                                        @else
                                                            <span class="text-muted">No categories selected</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-muted">Flat discount is enabled, but no discount rows were saved.</div>
                                @endif
                            </div>
                        @endif

                        @if ($pricingRules->is_volume_discount)
                            <div class="mb-4">
                                <h5 class="mb-3">Volume Discount Levels</h5>
                                @if ($pricingRules->volume_discounts->count())
                                    @foreach ($pricingRules->volume_discounts as $volumeDiscount)
                                        <div class="border rounded p-3 mb-3">
                                            <div class="mb-2">
                                                <strong>Categories:</strong>
                                                @if ($volumeDiscount->categories->count())
                                                    {{ $volumeDiscount->categories->pluck('category_name')->implode(', ') }}
                                                @else
                                                    <span class="text-muted">No categories selected</span>
                                                @endif
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm mb-0">
                                                    <thead class="thead-light">
                                                    <tr>
                                                        <th>Min</th>
                                                        <th>Max</th>
                                                        <th>Discount %</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse ($volumeDiscount->volume_discount_details as $detail)
                                                        <tr>
                                                            <td>{{ $detail->min }}</td>
                                                            <td>{{ $detail->max }}</td>
                                                            <td>{{ $detail->discount }}</td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="3" class="text-muted">No volume discount breakpoints found.</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-muted">Volume discount is enabled, but no volume rows were saved.</div>
                                @endif
                            </div>
                        @endif

                        @if ($pricingRules->is_order_value_discount)
                            <div>
                                <h5 class="mb-3">Order Value Discount</h5>
                                @if ($pricingRules->order_value_discount && $pricingRules->order_value_discount->order_value_discount_details->count())
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Order Value Upto</th>
                                                <th>Discount %</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($pricingRules->order_value_discount->order_value_discount_details as $detail)
                                                <tr>
                                                    <td>{{ $detail->order_value_upto }}</td>
                                                    <td>{{ $detail->discount }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-muted">Order value discount is enabled, but no ranges were saved.</div>
                                @endif
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        .gap-2 {
            gap: 0.5rem;
        }
    </style>
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/backpack/crud/js/crud.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
    <script src="{{ asset('packages/backpack/crud/js/show.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
@endsection

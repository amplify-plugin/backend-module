@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Customer Order Rules' => backpack_url('customer-order-rule'),
        \Route::is('customer-order-rule.edit') ? 'Edit' : 'Create' => false,
    ];
    parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ??
                    trans('backpack::crud.' . (Route::is('customer-order-rule.edit') ? 'edit' : 'add')) . ' ' . $crud->entity_name !!}.
            </small>

            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                        <i
                            class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div id="app">
    <create-customer-order-rule
        back_url="{{ '/'.$crud->route }}"
        class_name="{{ $crud->getCurrentOperation() === 'update' ? $crud->getEditContentClass() : $crud->getCreateContentClass() }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update' ? $crud->route . '/' . $entry->getKey() : $crud->route) }}"
        method="{{ $crud->getCurrentOperation() === 'update' ? 'put' : 'post' }}"
        customer_list="{{ json_encode($customer_list) }}"
        customer_order_rule_data= "{{json_encode($crud->query->first() ?? new \stdClass())}}"
        save_action="{{ json_encode($saveAction) }}">
    </create-customer-order-rule>
    </div>
@endsection

@section('after_scripts')
    <script src="{{ mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

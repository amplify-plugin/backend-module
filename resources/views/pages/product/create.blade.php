@extends(backpack_view('blank'))
@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Product' => backpack_url('product'),
        Route::is('product.edit') ? 'Edit' : 'Add' => false,
    ];

    parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ??
                trans('backpack::crud.' . (Route::is('product.edit') ? 'edit' : 'add')) . ' ' . $crud->entity_name !!}
                .</small>

            @if ($crud->hasAccess('list'))
                <small>
                    <a class="d-print-none font-sm" href="{{ url($crud->route) }}">
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
    <product-create class_name="col-md-12 bold-labels"
                    url="{{ url(
            $crud->getCurrentOperation() === 'update'
                ? $crud->route . '/' . $entry->getKey() . '/edit'
                : $crud->route . '/create',
        ) }}"
                    axios_url="{{ url($crud->getCurrentOperation() === 'update' ? $crud->route . '/' . $entry->getKey() : $crud->route) }}"
                    current_lang="{{ $crud->model->getAvailableLocales()[request()->input('locale') ?? App::getLocale()] ?? 'English' }}"
                    translation_enabled="{{ $crud->getCurrentOperation() === 'update' && $crud->model->translationEnabled() }}"
                    :unit-of-measurements='@json(config('amplify.pim.unit_of_measurements', []))'
                    available_locales="{{ json_encode($crud->model->getAvailableLocales() ?? []) }}"
                    translatable="{{ json_encode($translatable) }}"
                    product="{{ json_encode($product ?? array_fill_keys($crud->model->getFillable(), null)) }}"
                    published_status="{{ $product->status ?? '' }}"
                    product_classification="{{ json_encode($productClassification ?? new \stdClass()) }}"
                    attributes="{{ json_encode($attributes) }}" options="{{ json_encode($options) }}"
                    method="{{ $crud->getCurrentOperation() === 'update' ? 'put' : 'post' }}"
                    locale="{{ request('locale', 'en') }}"
                    active_tab="{{ request()->activeTab ?? 'BasicInfo' }}"
                    show_order_quantity_config_tab="{{ $show_order_quantity_config_tab }}"
                    can_publish="{{ backpack_user()->can(['product.publish']) }}"
                    customer_groups="{{ json_encode($customer_groups) }}"
                    permissions="{{ base64_encode(backpack_user()->getAllPermissions()->sortBy('name')->pluck('name')->toJson()) }}"
                    core_configs="{{ json_encode($core_configs) }}"
                    product_mandatory_fields="{{ json_encode($product_mandatory_fields) }}"
                    easy_ask_default_product_categories="{{ json_encode($easyAsk_default_product_categories) }}"
                    sku_default_attributes="{{ isset($sku_default_attributes) ? json_encode($sku_default_attributes) : json_encode([]) }}"
                    query_string="{{ json_encode($query_string) }}" timezone="{{ config('app.timezone') }}"
                    default_datetime_format="{{ getDefaultDateTimeFormat() }}"
                    product_search_by_id_prefix="{{ trim(config('amplify.search.product_search_by_id_prefix')) }}"
                    :use_product_specific_detail_page="{{ config('amplify.pim.use_product_specific_detail_page') ? 'true' : 'false' }}"
                    all_manufacturers="{{ json_encode($all_manufacturers) }}"
                    all_brands="{{ json_encode($all_brands) }}"
                    all_single_product_pages="{{ json_encode($all_single_product_pages) }}"
                    all_document_types="{{ json_encode($all_document_types) }}"
                    product_documents="{{ isset($product_documents) ? json_encode($product_documents) : json_encode([]) }}"
                    fields="{{ json_encode($crud->getCurrentFields()) }}"
                    accept_file_types="{{ json_encode(\Amplify\System\Backend\Models\DocumentType::ACCEPT_FILE_TYPES, JSON_THROW_ON_ERROR) }}"
                    use_minimum_order_quantity="{{ config('amplify.pim.use_minimum_order_quantity') }}"
                    save_action="{{ json_encode($saveAction) }}"
                    model_codes="{{ isset($product->modelCodes)
            ? json_encode(
                $product->modelCodes->map(
                    fn($item) => [
                        'code' => $item->id,
                        'label' => $item->code,
                    ],
                ),
            )
            : json_encode([]) }}"
    ></product-create>
@endsection

@section('after_scripts')
    <script src="{{ mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

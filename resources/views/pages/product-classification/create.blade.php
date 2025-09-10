@extends(backpack_view('blank'))
@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Product Classification' => backpack_url('product'),
        Route::is('product.edit') ? 'Edit' : 'Add' => false,
    ];
    parse_str(request()->getQueryString(), $qury_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('product.edit') ? 'edit' : 'add')).' '.$crud->entity_name !!}
                .</small>

            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}" class="d-print-none font-sm">
                        <i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i>
                        {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span>
                    </a>
                </small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <product-classification-create
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit'
                        : $crud->route.'/create') }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
        current_lang="{{ $crud->model->getAvailableLocales()[request()->input('locale') ?? App::getLocale()] ?? 'English' }}"
        translation_enabled="{{ $crud->getCurrentOperation() === 'update' && $crud->model->translationEnabled() }}"
        available_locales="{{ json_encode($crud->model->getAvailableLocales() ?? []) }}"
        class_name="col-md-12 bold-labels"
        translatable="{{ json_encode($translatable) }}"
        product_classification="{{ json_encode($productClassification ?? new \stdClass()) }}"
        attributes="{{ json_encode($attributes) }}"
        options="{{ json_encode($options) }}"
        method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : 'post'}}"
        active_tab="{{request()->activeTab ?? 'BasicInfo'}}"
        locale="{{request()->locale ?? 'en'}}"
        query_string="{{ json_encode($qury_string) }}"
        easy_ask_default_product_categories="{{ json_encode($easyAsk_default_product_categories) }}"
        product_list="{{ json_encode([]) }}"
        all_single_product_pages="{{ json_encode($all_single_product_pages) }}"
        save_action = "{{ json_encode($saveAction) }}"
    ></product-classification-create>
@endsection

@section('after_scripts')
    <script src="{{asset("vendor/backend/js/backend.js")}}"></script>
@endsection

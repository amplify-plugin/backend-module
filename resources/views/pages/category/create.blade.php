@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Category' => backpack_url('category'),
        Route::is('category.edit') ? 'Edit' : 'Add' => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
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
{{-- @dd(get_defined_vars(), $saveAction) --}}
    <category-create
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
        translatable="{{ json_encode($translatable ?? []) }}"
        local_category="{{json_encode($category ?? new \stdClass())}}"
        method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : 'post'}}"
        active_tab="{{request()->activeTab ?? 'BasicInfo'}}"
        locale="{{request()->locale ?? 'en'}}"
        query_string="{{ json_encode($query_string) }}"
        save_action="{{ json_encode($saveAction) }}"
        easy_ask_default_product_categories="{{ json_encode($easyAsk_default_product_categories) }}"
        categorization_required="{{ $categorization_required ? 'Y' : 'N' }}"
        catalogs="{{ json_encode($catalogs) }}"
    ></category-create>
@endsection

@section('after_scripts')
    <script src="{{  mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

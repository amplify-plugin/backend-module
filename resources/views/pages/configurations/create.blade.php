@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      'System Configuration' => request()->url()
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        </h2>
    </section>
@endsection

@section('content')
    <configuration
        app_url="{{ config('app.url') }}"
        url="{{ url($crud->getCurrentOperation() === 'update'
                    ? $crud->route.'/'.$entry->getKey().'/edit'
                    : $crud->route.'/create') }}"
        axios_url="{{ route('system-config.update') }}"
        translation_enabled="{{ $crud->getCurrentOperation() === 'update' && $crud->model->translationEnabled() }}"
        class_name="{{$crud->getEditContentClass() ?? $crud->getCreateContentClass()}}"
        product="{{ json_encode($product ?? array_fill_keys($crud->model->getFillable(), '')) }}"
        all_currencies="{{json_encode($currencies)}}"
        core_configuration_data="{{json_encode($coreConfigurationData)}}"
        available_locales="{{json_encode($availableLocales)}}"
        hierarchies="{{json_encode($hierarchies)}}"
        countries="{{json_encode($countries)}}"
        mail_configuration_data="{{json_encode($mail_configuration_data)}}"
        product_indexes="{{json_encode($product_indexes)}}"
        date_time_formats="{{json_encode($date_time_formats)}}"
        date_formats="{{json_encode($date_formats)}}"
        page_types="{{ json_encode($pageTypes) }}"
        menu_groups="{{ json_encode($menuGroups) }}"
        dds_dates="{{ json_encode($dds_dates ?? []) }}"
        catalogs="{{ json_encode($catalogs ?? []) }}"
        document_types="{{ json_encode($documentTypes ?? []) }}"
        timezone="{{ config('app.timezone') }}">
    </configuration>
@endsection

@section('after_scripts')
    <script>
        if (localStorage.getItem('systemTabActiveTab') == null) {
            localStorage.setItem('systemTabActiveTab', 'Basic');
        }
    </script>
    @include('cms::inc.full-page-loader')
    <script src="{{ asset("assets/js/app.js") }}"></script>
@endsection

@extends(backpack_view('blank'))

@php
    use Amplify\System\Utility\Models\ImportDefinition;
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Import Definition' => backpack_url('import-definition'),
        Route::is('category.edit') ? 'Edit' : 'Add' => false,
    ];
    parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ??
                    trans('backpack::crud.' . (Route::is('product.edit') ? 'edit' : 'add')) . ' ' . $crud->entity_name !!}.
            </small>

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
    <div id="app">
    <import-definition
        url="{{ url(
            $crud->getCurrentOperation() === 'update'
                ? $crud->route . '/' . $entry->getKey() . '/edit'
                : $crud->route . '/create',
        ) }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update' ? $crud->route . '/' . $entry->getKey() : $crud->route) }}"
        translation_enabled="{{ $crud->getCurrentOperation() === 'update' && $crud->model->translationEnabled() }}"
        method="{{ $crud->getCurrentOperation() === 'update' ? 'put' : 'post' }}"
        locale="{{ request()->locale ?? 'en' }}" query_string="{{ json_encode($query_string) }}"
        tables_name="{{ isset($tables_name) ? json_encode($tables_name) : json_encode([]) }}"
        import_definition_data="{{ isset($importDefinitionData) ? json_encode($importDefinitionData) : json_encode([]) }}"
        db_columns_data="{{ isset($dbColumns) ? json_encode($dbColumns) : json_encode([]) }}"
        attributes_data="{{ isset($attributes) ? json_encode($attributes) : json_encode([]) }}"
        all_hierarchies="{{ isset($all_hierarchies) && count($all_hierarchies) > 0 ? json_encode($all_hierarchies) : json_encode([]) }}"
        import_types="{{ json_encode(ImportDefinition::IMPORT_TYPES) }}"></import-definition>
    </div>
@endsection

@section('after_scripts')
    <script src="{{ mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

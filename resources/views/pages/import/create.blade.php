@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Import Definition' => backpack_url('import'),
        Route::is('category.edit') ? 'Edit' : 'Add' => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!!
                    $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('product.edit') ? 'edit' : 'add')).' '.$crud->entity_name
                    !!}.
            </small>

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
    <div id="app">
    <import
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit'
                        : $crud->route.'/create') }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
        method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : 'post'}}"
        class_name="{{($crud->getCurrentOperation() === 'update')
                        ? $crud->getEditContentClass()
                        :$crud->getCreateContentClass()}}"
        query_string="{{ json_encode($query_string) }}"
        import_definition="{{ isset($importDefinition) ? json_encode($importDefinition) : json_encode([])  }}"
        import_job_data="{{ isset($importJobData) ? json_encode($importJobData) : json_encode([]) }}"
        locale="{{request()->locale ?? 'en'}}"
        import_definition_create_route="{{route('import-definition.create','action_from=import_job')}}"
        available_locales="{{ collect(config('backpack.crud.locales')) }}"
        timezone="{{ config('app.timezone') }}"
    ></import>
    </div>
@endsection

@section('after_scripts')
    <script src="{{  mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

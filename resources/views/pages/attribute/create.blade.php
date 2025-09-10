@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Attribute' => backpack_url('attribute'),
        Route::is('attribute.edit') ? 'Edit' : 'Add' => false,
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
    <attribute-create
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit'
                        : $crud->route.'/create') }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
        current_lang="{{ $crud->model->getAvailableLocales()[request()->input('locale') ?? App::getLocale()] ?? 'English' }}"
        translation_enabled="{{ $crud->getCurrentOperation() === 'update' && $crud->model->translationEnabled() }}"
        available_locales="{{ json_encode($crud->model->getAvailableLocales() ?? []) }}"
        class_name="{{$crud->getEditContentClass() ?? $crud->getCreateContentClass()}}"
        translatable="{{ json_encode($translatable ?? []) }}"
        local_attribute="{{json_encode($attribute ?? new \stdClass())}}"
        method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : 'post'}}"
        locale="{{request()->locale ?? 'en'}}"
        query_string="{{ json_encode($query_string) }}"
        save_action = "{{ json_encode($saveAction) }}"
    ></attribute-create>
@endsection

@section('after_scripts')
    <script src="{{mix("js/backend.js", "vendor/backend")}}"></script>
@endsection

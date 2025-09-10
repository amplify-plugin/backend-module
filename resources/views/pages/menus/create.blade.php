@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Menu' => url($crud->route) . '?group_id=' . request('group_id'),
        Route::is('menu.edit') ? 'Edit' : (Route::is('menu.show') ? 'Preview' : 'Create') => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('nav-item.edit') ? 'edit' : (Route::is('nav-item.show') ? 'preview' : 'add'))).' '.$crud->entity_name !!}
                .</small>

            @if ($crud->hasAccess('list'))
                <small>
                    <a href="{{ url($crud->route) }}?group_id={{ request()->group_id }}" class="d-print-none font-sm">
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

    <menus-create
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit?group_id=' . request()->group_id :
                        ($crud->getCurrentOperation() === 'show' ? $crud->route.'/'.$entry->getKey().'/show?group_id=' . request()->group_id
                        : $crud->route.'/create?group_id=' . request()->group_id)) }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
        class_name="{{'col-lg-12' }}"
        method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : ($crud->getCurrentOperation() === 'show' ? 'get' : 'post')}}"
        query_string="{{ json_encode($query_string) }}"
        local_menu="{{ json_encode($local_menu ?? new \stdClass())}}"
        pages="{{ json_encode($pages) ?? json_encode([]) }}"
        group="{{ json_encode($group) }}"
        current_lang="{{ $crud->model->getAvailableLocales()[request()->input('locale') ?? App::getLocale()] ?? 'English' }}"
        translation_enabled="{{ $crud->getCurrentOperation() === 'update' && $crud->model->translationEnabled() }}"
        available_locales="{{ json_encode($crud->model->getAvailableLocales() ?? []) }}"
        save_action="{{ json_encode($saveAction) }}"
        locale="{{request()->locale ?? 'en'}}"
    ></menus-create>
@endsection

@section('after_scripts')
    <script src="{{  asset("vendor/backend/js/backend.js") }}"></script>
@endsection

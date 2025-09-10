@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'EventAction' => backpack_url('event-action'),
        Route::is('event-action.edit') ? 'Edit' : 'Create' => false,
    ];
    parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!!
                    $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('event-action.edit') ? 'edit' : 'add')).' '.$crud->entity_name
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
    <event-action
        class_name="{{$crud->getEditContentClass() ?? $crud->getCreateContentClass()}}"
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit'
                        : $crud->route.'/create') }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
        method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : 'post'}}"
        events="{{ json_encode($events) }}"
        event_action_data="{{ isset($event_action_data) ? json_encode($event_action_data) : '[]' }}"
        save_action="{{ json_encode($saveAction) }}"
    ></event-action>
@endsection

@section('after_scripts')
    <script src="{{  asset("vendor/backend/js/backend.js") }}"></script>
@endsection

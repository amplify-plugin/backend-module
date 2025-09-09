@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Option' => backpack_url('option'),
        Route::is('option.edit') ? 'Edit' : 'Add' => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('option.edit') ? 'edit' : 'add')).' '.$crud->entity_name !!}
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
    <customer-group-create
        url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit'
                        : $crud->route.'/create') }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
        class_name="{{ $crud->getCurrentOperation() === 'update' ? $crud->getEditContentClass() : $crud->getCreateContentClass()}}"
        method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : 'post'}}"
        active_tab="{{request()->activeTab ?? 'BasicInfo'}}"
        query_string="{{ json_encode($query_string) }}"
        customer_group_pricing_type="{{json_encode($customer_group_pricing_type ?? new \stdClass())}}"
        customer_group_data="{{json_encode($customer_group_data ?? new \stdClass())}}"
        categories="{{json_encode($categories ?? new \stdClass())}}"
        save_action = "{{ json_encode($saveAction) }}"
    ></customer-group-create>
@endsection

@section('after_scripts')
    <script src="{{asset("assets/js/app.js")}}"></script>
@endsection

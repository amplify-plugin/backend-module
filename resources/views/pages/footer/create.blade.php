@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Footer' => backpack_url('footer'),
        Route::is('footer.edit') ? 'Edit' : (Route::is('footer.show') ? 'Preview' : 'Add') => false,
    ];
  parse_str(request()->getQueryString(), $query_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                {!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('footer.edit') ? 'edit' : (Route::is('footer.show') ? 'preview' : 'add'))).' '.$crud->entity_name !!}
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
    <footer-create
            url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit' :
                        ($crud->getCurrentOperation() === 'show' ? $crud->route.'/'.$entry->getKey().'/show'
                        : $crud->route.'/create')) }}"
            axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"

            method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : ($crud->getCurrentOperation() === 'show' ? 'get' : 'post')}}"
            query_string="{{ json_encode($query_string) }}"
            footer_templates="{{ json_encode(array_values(config('amplify.cms.themes'))) }}"
            active_template="{{ theme()->id }}"
            merch_zones="{{ json_encode($merchandising_zones ?? []) }}"
            banner_zones="{{ json_encode($banner_zones ?? []) }}"
            banner_item_codes="{{ json_encode($banner_item_codes ?? []) }}"
            content_lists="{{ json_encode($content_lists ?? []) }}"
            menu_group_lists="{{ json_encode($menu_group_lists ?? []) }}"
            active_widgets="{{$active_widgets ?? json_encode([])}}"
            local_footer="{{json_encode($footer ?? new \stdClass())}}"
            footer_layouts="{{json_encode($footer_layouts) ?? json_encode([])}}"
            save_action="{{ json_encode($saveAction) }}"
    ></footer-create>
@endsection

@section('after_scripts')
    <script src="{{  mix("js/backend.js", "vendor/backend") }}"></script>
@endsection

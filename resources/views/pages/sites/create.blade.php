@extends(backpack_view('blank'))
@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Site' => backpack_url('site'),
        Route::is('site.edit') ? 'Edit' : 'Add' => false,
    ];
    parse_str(request()->getQueryString(), $qury_string);
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('site.edit') ? 'edit' : 'add')).' '.$crud->entity_name !!}
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
    <site-create
            url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey().'/edit'
                        : $crud->route.'/create') }}"
            axios_url="{{ url($crud->getCurrentOperation() === 'update'
                        ? $crud->route.'/'.$entry->getKey()
                        : $crud->route) }}"
            class_name="col-md-12 bold-labels"
            method="{{$crud->getCurrentOperation() === 'update'
                        ? 'put'
                        : 'post'}}"
            active_tab="{{request()->activeTab ?? 'BasicInfo'}}"
            query_string="{{ json_encode($qury_string) }}"
            site_data="{{ isset($sitesData) ? json_encode($sitesData) : json_encode([]) }}"
            all_templates="{{ json_encode(array_values(config('amplify.cms.themes'))) }}"
            all_pages="{{ json_encode(\Amplify\System\Cms\Models\Page::all()) }}"
            search_config_data="{{ isset($sitesData) ? json_encode(optional($sitesData)->search_configuration) : json_encode([]) }}"
    ></site-create>
@endsection

@section('after_scripts')
    <script src="{{asset("assets/js/app.js")}}"></script>
@endsection

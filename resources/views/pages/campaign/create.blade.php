@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'campaign' => backpack_url('campaign'),
        Route::is('campaign.edit') ? 'Edit' : 'Add' => false,
    ];
    parse_str(request()->getQueryString(), $query_string);
@endphp


@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('campaign.edit') ? 'edit' : 'add')).' '.$crud->entity_name !!}
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
    @php
        $method = 'post';
        $store_or_update_url = route('admin.campaign.store');

        if ($crud->getCurrentOperation() === 'update') {
            $crud->entry->load('products');
            $method = 'put';
            $store_or_update_url = route('admin.campaign.update', $entry->getKey());
        } else {
            $entry = new \Amplify\System\Marketing\Models\Campaign();
        }
    @endphp
    <campaign-create
            class_name="{{$crud->getEditContentClass() ?? $crud->getCreateContentClass()}}"
            entry="{{ json_encode($entry) }}"
            page_list="{{ json_encode($pages) }}"
            banner_zone_list="{{ json_encode($banner_zones) }}"
            discount_types="{{ json_encode($crud->model::DISCOUNT_TYPE) }}"
            method="{{ $method }}"
            store_or_update_url="{{ $store_or_update_url }}"
            category_url="{{ route('mega-menu.category') }}"
    ></campaign-create>
@endsection


@section('after_scripts')
    <script src="{{asset("vendor/backend/js/backend.js")}}"></script>
@endsection


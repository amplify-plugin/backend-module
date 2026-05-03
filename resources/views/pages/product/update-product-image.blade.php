@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      'Add Image to Products' => request()->url()
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
    <image-bulk-product
            class_name="{{$crud->getEditContentClass() ?? $crud->getCreateContentClass()}}"
            axios_url="{{ route('products.bulk-image.update') }}"
    />
@endsection

@section('after_scripts')
    @include('cms::inc.full-page-loader')
    <script src="{{ mix("js/backend.js", "vendor/backend") }}"></script>
@endsection
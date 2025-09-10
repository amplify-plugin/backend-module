@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.add') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('backpack::crud.add').' '.$crud->entity_name !!}.</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection
@section('content')
    <report-create
        url="{{ url($crud->getCurrentOperation() === 'update'? $crud->route.'/'.$entry->getKey().'/edit' : $crud->route.'/create') }}"
        axios_url="{{ url($crud->getCurrentOperation() === 'update'? $crud->route.'/'.$entry->getKey() : $crud->route) }}"
        method="{{ $crud->getCurrentOperation() === 'update'? 'put' : 'post' }}"
        entry="{{ $crud->entry }}"
        save_action="{{ json_encode($saveAction) }}"
    ></report-create>
@endsection

@section('after_scripts')
    <script src="{{mix("js/backend.js", "vendor/backend")}}"></script>
@endsection

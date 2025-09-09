@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route) . '?group_id=' . request('group_id'),
      trans('backpack::crud.list') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>
                <a href="{{ route('menu-group.index') }}" class="d-print-none font-sm"><i
                        class="la la-angle-double-left"></i>
                    Back to all <span>menus</span></a>
            </small>
            <div class="d-none">
                <small id="datatable_info_stack">test{!! $crud->getSubheading() ?? '' !!}</small>
            </div>

        </h2>
    </div>
@endsection

@section('content')
    <!-- Default box -->
    <div class="row">

        <!-- THE ACTUAL CONTENT -->
        <div class="{{ $crud->getListContentClass() }}">

            <div class="row mb-0">
                <div class="col-sm-6">
                    @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
                        <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                            @include('crud::inc.button_stack', ['stack' => 'top'])

                        </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none"></div>
                </div>
            </div>

            {{-- Backpack List Filters --}}
            @if ($crud->filtersEnabled())
                @include('backend::pages.menus.filters_navbar')
            @endif

            <table id="crudTable"
                   class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2"
                   cellspacing="0">
                <thead>
                <tr>
                    {{-- Table columns --}}
                    @foreach ($crud->columns() as $column)
                        <th
                            data-orderable="{{ var_export($column['orderable'], true) }}"
                            data-priority="{{ $column['priority'] }}"
                            @if(isset($column['exportOnlyField']) && $column['exportOnlyField'] === true)
                                data-visible="false"
                            data-visible-in-table="false"
                            data-can-be-visible-in-table="false"
                            data-visible-in-modal="false"
                            data-visible-in-export="true"
                            data-force-export="true"
                            @else
                                data-visible-in-table="{{var_export($column['visibleInTable'] ?? false)}}"
                            data-visible="{{var_export($column['visibleInTable'] ?? true)}}"
                            data-can-be-visible-in-table="true"
                            data-visible-in-modal="{{var_export($column['visibleInModal'] ?? true)}}"
                            @if(isset($column['visibleInExport']))
                                @if($column['visibleInExport'] === false)
                                    data-visible-in-export="false"
                            data-force-export="false"
                            @else
                                data-visible-in-export="true"
                            data-force-export="true"
                            @endif
                            @else
                                data-visible-in-export="true"
                            data-force-export="false"
                            @endif
                            @endif
                        >
                            {!! $column['label'] !!}
                        </th>
                    @endforeach

                    @if ( $crud->buttons()->where('stack', 'line')->count() )
                        <th data-orderable="false"
                            data-priority="{{ $crud->getActionsColumnPriority() }}"
                            data-visible-in-export="false"
                        >{{ trans('backpack::crud.actions') }}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                <tr>
                    {{-- Table columns --}}
                    @foreach ($crud->columns() as $column)
                        <th>{!! $column['label'] !!}</th>
                    @endforeach

                    @if ( $crud->buttons()->where('stack', 'line')->count() )
                        <th>{{ trans('backpack::crud.actions') }}</th>
                    @endif
                </tr>
                </tfoot>
            </table>

            @if ( $crud->buttons()->where('stack', 'bottom')->count() )
                <div id="bottom_buttons" class="d-print-none text-center text-sm-left">
                    @include('crud::inc.button_stack', ['stack' => 'bottom'])

                    <div id="datatable_button_stack" class="float-right text-right hidden-xs"></div>
                </div>
            @endif

        </div>

    </div>

@endsection

@section('after_styles')
    <!-- DATA TABLES -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

    <link rel="stylesheet"
          href="{{ asset('packages/backpack/crud/css/crud.css').'?v='.config('backpack.base.cachebusting_string') }}">
    <link rel="stylesheet"
          href="{{ asset('packages/backpack/crud/css/form.css').'?v='.config('backpack.base.cachebusting_string') }}">
    <link rel="stylesheet"
          href="{{ asset('packages/backpack/crud/css/list.css').'?v='.config('backpack.base.cachebusting_string') }}">

    <!-- CRUD LIST CONTENT - crud_list_styles stack -->
    @stack('crud_list_styles')
@endsection

@section('after_scripts')
    @include('crud::inc.datatables_logic')
    <script
        src="{{ asset('packages/backpack/crud/js/crud.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
    <script
        src="{{ asset('packages/backpack/crud/js/form.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>
    <script
        src="{{ asset('packages/backpack/crud/js/list.js').'?v='.config('backpack.base.cachebusting_string') }}"></script>

    <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
    @stack('crud_list_scripts')
    <script>
        var group_id = '{{ request("group_id") }}';

        $(document).ready(function () {
            $('#crudTable_reset_button').attr('href', "{{ url($crud->route . '?group_id=' . request()->group_id) }}");
        });
    </script>

@endsection

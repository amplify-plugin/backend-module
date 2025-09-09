@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.list') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small id="datatable_info_stack">{!! $crud->getSubheading() ?? '' !!}</small>
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
                            @if ($crud->hasAccess('create'))
                                <a href="{{ url($crud->route.'/create') }}" class="btn btn-primary"
                                   data-style="zoom-in"><span class="ladda-label"><i
                                            class="la la-plus"></i> {{ trans('backpack::crud.add') }} {{ $crud->entity_name }}</span></a>
                            @endif
                            @if ($crud->get('reorder.enabled') && $crud->hasAccess('reorder'))
                                <a id="render-btn-loader" onclick="renderButtonLoader(event)"
                                   href="{{ url($crud->route.'/reorder') }}" class="btn btn-outline-primary"
                                   data-style="zoom-in"><span class="ladda-label"><i
                                            class="la la-arrows"></i> {{ trans('backpack::crud.reorder') }} {{ $crud->entity_name_plural }}</span></a>
                            @endif
                        </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none"></div>
                </div>
            </div>

            {{-- Backpack List Filters --}}
            @if ($crud->filtersEnabled())
                @include('crud::inc.filters_navbar')
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

                            {{-- If it is an export field only, we are done. --}}
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

        </div>
        <div id="bottom_buttons" class="d-print-none text-center text-sm-left">
            <div class="form-group">
                <label class="control-label"><b>Order Notes</b></label>
                <div class="col-sm-12">
                    <textarea class="form-control input-values" disabled name="notes" id="order-note">{{ $order->notes }}</textarea>
                </div>
            </div>
            @if ( $crud->buttons()->where('stack', 'bottom')->count() )
                @include('crud::inc.button_stack', ['stack' => 'bottom'])
                <div id="datatable_button_stack" class="float-right text-right hidden-xs"></div>
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
        function renderButtonLoader(event) {
            document.getElementById("render-btn-loader").innerHTML
                = `<i style="margin-bottom: 2px;" class="spinner-border mr-1 spinner-border-sm"></i> Please wait..`;
        }
    </script>

    <script>
        $(document).ready(function () {
            var disabled = true;
            $("#edit-form").click(function () {
                if (disabled == true) {
                    $('.input-values').removeAttr('disabled');
                } else {
                    $('.input-values').attr('disabled', 'disabled');
                }
                disabled = !disabled;

                let id = "<?php echo $order->id; ?>";
                let url = "{{ route('order.edit', ':id') }}";
                url = url.replace(':id', id);
                document.location.href=url;
            });

            $("#update-btn").click(function () {
                let quantities     = $('input[name="qty[]"]');
                let addresses      = $('select[name="addresses[]"]');
                let order_line_ids = $('input[name="order_line_ids[]"]');
                let prices         = $('input[name="price[]"]');
                let orderNotes     = $('#order-note').val();

                let new_values = [];

                $.each(quantities, function (index, qty) {
                    let value = {
                        id     : order_line_ids[index].value,
                        qty    : qty.value,
                        address: addresses[index].value,
                        price  : prices[index].value
                    }

                    new_values.push(value);
                });

                $.ajax({
                    url    : "{{ route('update-order-info') }}",
                    type   : 'POST',
                    data   : {
                        data    : new_values,
                        order_id: {{ $order->id }},
                        notes   : orderNotes,
                        _token  : '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            window.location.href = "{{ route('order.index') }}"
                        } else {
                            new Noty({
                                type: "error",
                                text: response.message,
                            }).show();
                        }
                    }
                });

            })
        });
    </script>
@endsection

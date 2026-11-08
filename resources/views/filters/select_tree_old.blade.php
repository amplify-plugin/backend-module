<li filter-name="{{ $filter->name }}"
    filter-type="{{ $filter->type }}"
    filter-key="{{ $filter->key }}"
    class="nav-item dropdown {{ Request::get($filter->name)?'active':'' }}">
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
       aria-expanded="false">{{ $filter->label }} <span class="caret"></span></a>
    <div class="dropdown-menu p-0">
        <input type="text" autocomplete="off" id="{{$filter->name}}" placeholder="Select">

        <div class="form-group backpack-filter mb-0 d-none">
            {{--<select
                id="filter_{{ $filter->key }}"
                name="filter_{{ $filter->key }}"
                class="form-control input-sm select2"
                placeholder="{{ $filter->placeholder }}"
                data-filter-key="{{ $filter->key }}"
                data-filter-type="select2"
                data-filter-name="{{ $filter->name }}"
                data-language="{{ str_replace('_', '-', app()->getLocale()) }}"
            >
                <option value="">-</option>
                @if (is_array($filter->values) && count($filter->values))
                    @foreach($filter->values as $key => $value)
                        <option value="{{ $key }}"
                                @if($filter->isActive() && $filter->currentValue == $key)
                                selected
                            @endif
                        >
                            {{ $value }}
                        </option>
                    @endforeach
                @endif
            </select>--}}
        </div>
    </div>
</li>

{{-- ########################################### --}}
{{-- Extra CSS and JS for this particular filter --}}

{{-- FILTERS EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

@push('crud_list_styles')
    <link href="{{ asset('vendor/combo-tree/style.css') }}" rel="stylesheet" type="text/css"/>
    <!-- include select2 css-->
    <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <style>
        .form-inline .select2-container {
            display: inline-block;
        }

        .select2-drop-active {
            border: none;
        }

        .select2-container .select2-choices .select2-search-field input, .select2-container .select2-choice, .select2-container .select2-choices {
            border: none;
        }

        .select2-container-active .select2-choice {
            border: none;
            box-shadow: none;
        }

        .select2-container--bootstrap .select2-dropdown {
            margin-top: -2px;
            margin-left: -1px;
        }

        .select2-container--bootstrap {
            position: relative !important;
            top: 0px !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.0.45/css/materialdesignicons.min.css">

    <style>
        .comboTreeParentPlus {
            left: -15px !important;
        }

        .nav-item.dropdown.show .dropdown-menu {
            {{ $filter->options['styles']['width'] ?? '' }}
        }

        .comboTreeArrowBtn,
        .comboTreeArrowBtn .comboTreeArrowBtnImg {
            display: flex;
        }

        .comboTreeArrowBtn .comboTreeArrowBtnImg {
            align-items: center;
        }
    </style>
@endpush

@push('crud_list_scripts')
    <script src="{{ asset('vendor/combo-tree/combo-tree.js') }}"></script>

    <script>
        jQuery(document).ready(function ($) {
            let isMultiple                 = "{{$filter->options['isMultiple'] ?? true}}";
            let {{$filter->name}}          = {!! json_encode($filter->values) !!};
            let {{$filter->name}}_instance = $('#{{$filter->name}}').comboTree({
                source       : {{$filter->name}},
                isMultiple   : isMultiple,
                cascadeSelect: true,
                collapse     : true,
            });
            let selectionIdList            = isMultiple
                                             ? JSON.parse({!! json_encode(request()->{$filter->name} ?? "[]") !!})
                                             : [{!! request()->{$filter->name} ?? '' !!}];
            {{$filter->name}}_instance.setSelection(selectionIdList)

            let value     = '';
            let parameter = '{{ $filter->name }}';

            let selector       = `#${parameter}`;
            let selectorTarget = document.querySelector(selector);

            //let target = filter.closest('.dropdown-menu').querySelectorAll("input[type=checkbox]");
            let target   = selectorTarget.closest('.dropdown-menu').querySelectorAll(".comboTreeItemTitle");
            let selected = [];

            target.forEach(el => {
                //el.parentNode.addEventListener('click', (eve) => {
                el.addEventListener('click', (eve) => {
                    /*let selectorFilter = eve.target.closest(`[filter-name=${parameter}]`);
                    let filterName     = selectorFilter/!*.getAttribute('data-filter-name')*!/;
                    let filter_key     = selectorFilter/!*.getAttribute('data-filter-key')*!/;*/
                    let filter_name = parameter

                    selected = getChecked(target);

                    if (isMultiple) {
                        let values = selected.filter(function (e) {
                            return e === 0 || e
                        });
                        // stringify only if values is not empty. otherwise it will be '[]'.
                        value      = values.length ? JSON.stringify(values) : '';
                    } else {
                        value = selected;
                    }

                    // behaviour for ajax table
                    let ajax_table  = $("#crudTable").DataTable();
                    let current_url = ajax_table.ajax.url();
                    let new_url     = addOrUpdateUriParameter(current_url, parameter, value);

                    // replace the datatables ajax url with new_url and reload it
                    new_url = normalizeAmpersand(new_url.toString());
                    ajax_table.ajax.url(new_url).load();

                    // add filter to URL
                    crud.updateUrl(new_url);

                    // mark this filter as active in the navbar-filters
                    if (URI(new_url).hasQuery(parameter, true)) {
                        $("li[filter-name=" + filter_name + "]").addClass('active');
                    } else {
                        $("li[filter-name=" + filter_name + "]").removeClass("active");
                        $("li[filter-name=" + filter_name + "]").find('.dropdown-menu').removeClass("show");
                    }

                })
            });

            function getChecked(filter3) {
                selected   = [];
                let target = {};
                filter3.forEach(target => {
                    //target.checked ? selected.push(target.parentNode.getAttribute("data-id")) : false
                    /*console.log(
                        JSON.stringify(target.getAttribute("data-id")),
                        '"' + target.getAttribute("data-id") + '"'
                    );*/

                    isMultiple
                    ? target.querySelector("input[type=checkbox]").checked
                      ? selected.push(target.getAttribute("data-id"))
                      : false
                    : selected = {{$filter->name}}_instance.getSelectedIds()[0]
                })
                return selected;
            }
        });
    </script>

    <!-- include select2 js-->
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>
    @if (app()->getLocale() !== 'en')
        <script
            src="{{ asset('packages/select2/dist/js/i18n/' . str_replace('_', '-', app()->getLocale()) . '.js') }}"></script>
    @endif

    <script>
        jQuery(document).ready(function ($) {
            // trigger select2 for each untriggered select2 box
            $('select[data-filter-type=select2]').not('[data-filter-enabled]').each(function () {
                var filterName = $(this).attr('data-filter-name');
                var filter_key = $(this).attr('data-filter-key');
                var element    = $(this);

                $(this).attr('data-filter-enabled', 'true');

                var obj = $(this).select2({
                    allowClear    : true,
                    closeOnSelect : false,
                    theme         : "bootstrap",
                    dropdownParent: $(this).parent('.form-group'),
                    placeholder   : $(this).attr('placeholder'),
                });

                $(this).change(function () {
                    var value     = $(this).val();
                    var parameter = $(this).attr('data-filter-name');

                    // behaviour for ajax table
                    var ajax_table  = $("#crudTable").DataTable();
                    var current_url = ajax_table.ajax.url();
                    var new_url     = addOrUpdateUriParameter(current_url, parameter, value);

                    // replace the datatables ajax url with new_url and reload it
                    new_url = normalizeAmpersand(new_url.toString());
                    ajax_table.ajax.url(new_url).load();

                    // add filter to URL
                    crud.updateUrl(new_url);

                    // mark this filter as active in the navbar-filters
                    if (URI(new_url).hasQuery(parameter, true)) {
                        $("li[filter-key=" + filter_key + "]").addClass('active');
                    } else {
                        $("li[filter-key=" + filter_key + "]").removeClass("active");
                        $("li[filter-key=" + filter_key + "]").find('.dropdown-menu').removeClass("show");
                    }
                });

                // when the dropdown is opened, autofocus on the select2
                $("li[filter-key=" + filter_key + "]").on('shown.bs.dropdown', function () {
                    $('select[data-filter-key=' + filter_key + ']').select2('open');
                });

                // clear filter event (used here and by the Remove all filters button)
                $("li[filter-key=" + filter_key + "]").on('filter:clear', function (e) {
                    // console.log('select2 filter cleared');
                    $("li[filter-key=" + filter_key + "]").removeClass('active');
                    $('#filter_' + filter_key).val(null).trigger('change');
                });
            });
        });
    </script>
@endpush


@extends(backpack_view('blank'))

@php
    $breadcrumbs = [
        'Admin' => backpack_url('dashboard'),
        'Attribute' => backpack_url('attribute'),
        $attribute->name => backpack_url("attribute/{$crud->getCurrentEntryId()}/show"),
        'Reorder Values' => false,
    ];

@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
            <small>{!! $crud->getSubheading() ?? trans('backpack::crud.'.(Route::is('attribute.edit') ? 'edit' : 'add')).' '.$crud->entity_name !!}
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
    <?php
    $tree = $entries->map(function ($entry) use ($crud) {
        return [
            'id' => $entry->attribute_value,
            'label' => $entry->attribute_value,
            'lft' => $entry->sequence,
            'children' => [],
        ];
    })->toArray();

    ?>
    <div class="row mt-4">
        <div class="{{ $crud->getReorderContentClass() }}">
            <div class="card">
                <div class="card-body">
                    <p>Caution: For large Items if browser pop up any alert please select
                        <code>Wait</code>. {{ trans('backpack::crud.reorder_text') }}.</p>
                    <ol class="sortable mt-0" id="sortable-container" style="overflow: auto; height: 60vh">
                    </ol>
                </div>
            </div>
            <button id="toArray" class="btn btn-success" data-style="zoom-in"><i
                        class="la la-save"></i> {{ trans('backpack::crud.save') }}</button>
        </div>
    </div>
@endsection

@section('after_styles')
    <style>
        .ui-sortable .placeholder {
            outline: 1px dashed #4183C4;
            /*-webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            margin: -1px;*/
        }

        .ui-sortable .mjs-nestedSortable-error {
            background: #fbe3e4;
            border-color: transparent;
        }

        .ui-sortable ol {
            margin: 0;
            padding: 0;
            padding-left: 30px;
        }

        ol.sortable, ol.sortable ol {
            margin: 0 0 0 25px;
            padding: 0;
            list-style-type: none;
        }

        ol.sortable {
            margin: 2em 0;
        }

        .sortable li {
            margin: 5px 0 0 0;
            padding: 0;
        }

        .sortable li div {
            border: 1px solid #ddd;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            padding: 6px;
            margin: 0;
            cursor: move;
            background-color: #f4f4f4;
            color: #444;
            border-color: #00acd6;
        }

        .sortable li.mjs-nestedSortable-branch div {
            /*background-color: #00c0ef;*/
            /*border-color: #00acd6;*/
        }

        .sortable li.mjs-nestedSortable-leaf div {
            /*background-color: #00c0ef;*/
            border: 1px solid #ddd;
        }

        li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
            border-color: #999;
            background: #fafafa;
        }

        .ui-sortable .disclose {
            cursor: pointer;
            width: 10px;
            display: none;
        }

        .sortable li.mjs-nestedSortable-collapsed > ol {
            display: none;
        }

        .sortable li.mjs-nestedSortable-branch > div > .disclose {
            display: inline-block;
        }

        .sortable li.mjs-nestedSortable-collapsed > div > .disclose > span:before {
            content: '+ ';
        }

        .sortable li.mjs-nestedSortable-expanded > div > .disclose > span:before {
            content: '- ';
        }

        .ui-sortable h1 {
            font-size: 2em;
            margin-bottom: 0;
        }

        .ui-sortable h2 {
            font-size: 1.2em;
            font-weight: normal;
            font-style: italic;
            margin-top: .2em;
            margin-bottom: 1.5em;
        }

        .ui-sortable h3 {
            font-size: 1em;
            margin: 1em 0 .3em;;
        }

        .ui-sortable p, .ui-sortable ol, .ui-sortable ul, .ui-sortable pre, .ui-sortable form {
            margin-top: 0;
            margin-bottom: 1em;
        }

        .ui-sortable dl {
            margin: 0;
        }

        .ui-sortable dd {
            margin: 0;
            padding: 0 0 0 1.5em;
        }

        .ui-sortable code {
            background: #e5e5e5;
        }

        .ui-sortable input {
            vertical-align: text-bottom;
        }

        .ui-sortable .notice {
            color: #c33;
        }
    </style>
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/jquery-ui-dist/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('packages/nestedSortable/jquery.mjs.nestedSortable2.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        var tree = @json($tree);

        function buildTree(nodes, isRoot = true) {
            const fragment = document.createDocumentFragment();
            const ol = isRoot ? null : document.createElement("ol");

            nodes
                .slice() // don't mutate original data
                .sort((a, b) => {
                    if (a.lft == null && b.lft == null) return 0;
                    if (a.lft == null) return 1;
                    if (b.lft == null) return -1;
                    return a.lft - b.lft;
                })
                .forEach(node => {
                    const li = document.createElement("li");
                    li.id = `list_${node.id}`;

                    li.innerHTML = `
        <div>
          <span class="disclose"><span></span></span>
            ${node.label}
        </div>
      `;

                    // children get wrapped in <ol>
                    if (node.children && node.children.length > 0) {
                        li.appendChild(buildTree(node.children, false));
                    }

                    if (isRoot) {
                        fragment.appendChild(li);
                    } else {
                        ol.appendChild(li);
                    }
                });

            return isRoot ? fragment : ol;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById("sortable-container");
            container.appendChild(buildTree(tree, true));
        });

        jQuery(document).ready(function ($) {
            var isRtl = Boolean("{{ (config('backpack.base.html_direction') === 'rtl') ? true : false }}");
            if (isRtl) {
                $(" <style> .ui-sortable ol {margin: 0;padding: 0;padding-right: 30px;}ol.sortable, ol.sortable ol {margin: 0 25px 0 0;padding: 0;list-style-type: none;}.ui-sortable dd {margin: 0;padding: 0 1.5em 0 0;}</style>").appendTo("head")
            }

            // initialize the nested sortable plugin
            $('.sortable').nestedSortable({
                forcePlaceholderSize: true,
                handle: 'div',
                helper: 'clone',
                items: 'li',
                opacity: .6,
                placeholder: 'placeholder',
                revert: 250,
                tabSize: 25,
                rtl: isRtl,
                tolerance: 'pointer',
                toleranceElement: '> div',
                maxLevels: {{ $crud->get('reorder.max_level') ?? 3 }},
                isTree: true,
                expandOnHover: 10000,
                startCollapsed: true
            });

            $('.disclose').on('click', function () {
                $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
            });

            $('#toArray').click(function (e) {
                // get the current tree order
                const entries = $('ol.sortable').nestedSortable('toArray', {
                    startDepthCount: 0,
                    expression: /(.+)_(.+)/
                });

                // send it with POST
                $.ajax({
                    url: '{{ url(Request::path()) }}',
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    data: JSON.stringify({tree: entries}),
                })
                    .done(function () {
                        new Noty({
                            type: "success",
                            text: "<strong>{{ trans('backpack::crud.reorder_success_title') }}</strong><br>{{ trans('backpack::crud.reorder_success_message') }}"
                        }).show();
                        setTimeout(() => {
                            window.location.replace('{{ backpack_url('attribute') }}');
                        }, 2500);
                    })
                    .fail(function (xhr) {
                        new Noty({
                            type: "error",
                            text: "<strong>{{ trans('backpack::crud.reorder_error_title') }}</strong><br>{{ trans('backpack::crud.reorder_error_message') }}"
                        }).show();
                    });

            });

            $.ajaxPrefilter(function (options, originalOptions, xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                }
            });

        });
    </script>
@endsection

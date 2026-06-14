{{-- State select2 from ajax (stores iso2 in customers.state / customer_addresses.state) --}}
@php
    $connected_entity = new $field['model'];
    $connected_entity_key_name = 'iso2';
    $old_value = old_empty_or_null($field['name'], false) ?? $field['value'] ?? $field['default'] ?? false;

    // Backpack sets BelongsTo entity field values to the related model id; we store iso2 in customers.state.
    if (isset($field['entity']) && $crud->entry && $old_value && ! is_object($old_value)) {
        $related = $crud->entry->{$field['entity']};

        if ($related && (string) $related->getKey() === (string) $old_value) {
            $old_value = $related->{$connected_entity_key_name};
        }
    }

    if (! $old_value && $crud->entry?->{$field['name']}) {
        $old_value = $crud->entry->{$field['name']};
    }

    $field['delay'] = $field['delay'] ?? 500;
    $field['allows_null'] = $field['allows_null'] ?? $crud->model::isColumnNullable($field['name']);
    $field['placeholder'] = $field['placeholder'] ?? trans('backpack::crud.select_entry');
    $field['attribute'] = $field['attribute'] ?? 'name';
    $field['minimum_input_length'] = $field['minimum_input_length'] ?? 0;

    $item = null;

    if (is_object($old_value)) {
        $item = $old_value;
    } elseif ($old_value) {
        if (isset($field['entity']) && $crud->entry) {
            $related = $crud->entry->{$field['entity']};

            if ($related && $related->{$connected_entity_key_name} === $old_value) {
                $item = $related;
            }
        }

        if (! $item) {
            $item = $connected_entity->where($connected_entity_key_name, $old_value)->first();

            if (! $item && isset($field['dependencies'])) {
                $query = $connected_entity->where($connected_entity_key_name, $old_value);

                foreach (Arr::wrap($field['dependencies']) as $dependency) {
                    $dependencyValue = old($dependency) ?? ($crud->entry?->{$dependency} ?? null);

                    if ($dependencyValue) {
                        $query->where($dependency, $dependencyValue);
                    }
                }

                $item = $query->first();
            }
        }
    }
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    <select
        name="{{ $field['name'] }}"
        style="width: 100%"
        data-init-function="bpFieldInitSelect2StateElement"
        data-field-is-inline="{{ var_export($inlineCreate ?? false) }}"
        data-column-nullable="{{ var_export($field['allows_null']) }}"
        data-dependencies="{{ isset($field['dependencies']) ? json_encode(Arr::wrap($field['dependencies'])) : json_encode([]) }}"
        data-placeholder="{{ $field['placeholder'] }}"
        data-minimum-input-length="{{ $field['minimum_input_length'] }}"
        data-data-source="{{ $field['data_source'] }}"
        data-method="{{ $field['method'] ?? 'GET' }}"
        data-field-attribute="{{ $field['attribute'] }}"
        data-connected-entity-key-name="{{ $connected_entity_key_name }}"
        data-include-all-form-fields="{{ isset($field['include_all_form_fields']) ? ($field['include_all_form_fields'] ? 'true' : 'false') : 'false' }}"
        data-ajax-delay="{{ $field['delay'] }}"
        data-language="{{ str_replace('_', '-', app()->getLocale()) }}"
        @include('crud::fields.inc.attributes', ['default_class' => 'form-control'])
    >
        @if ($item)
            @if ($field['allows_null'])
                <option value="">
                    {{ $field['placeholder'] }}
                </option>
            @endif

            <option value="{{ $item->{$connected_entity_key_name} }}" selected>
                {{ $item->{$field['attribute']} }}
            </option>
        @endif
    </select>

    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')

@push('crud_fields_styles')
    @loadOnce('packages/select2/dist/css/select2.min.css')
    @loadOnce('packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css')
    @if ($field['allows_null'])
        @loadOnce('select2_state_custom_css')
        <style type="text/css">
            .select2-selection__clear::after {
                content: ' {{ trans('backpack::crud.clear') }}';
            }
        </style>
        @endLoadOnce
    @endif
@endpush

@push('crud_fields_scripts')
    @loadOnce('packages/select2/dist/js/select2.full.min.js')
    @if (app()->getLocale() !== 'en')
        @loadOnce('packages/select2/dist/js/i18n/' . str_replace('_', '-', app()->getLocale()) . '.js')
    @endif
@endpush

@push('crud_fields_scripts')
@loadOnce('bpFieldInitSelect2StateElement')
<script>
    function bpFieldInitSelect2StateElement(element) {
        var form = element.closest('form');
        var $placeholder = element.attr('data-placeholder');
        var $minimumInputLength = element.attr('data-minimum-input-length');
        var $dataSource = element.attr('data-data-source');
        var $method = element.attr('data-method');
        var $fieldAttribute = element.attr('data-field-attribute');
        var $connectedEntityKeyName = element.attr('data-connected-entity-key-name');
        var $includeAllFormFields = element.attr('data-include-all-form-fields') == 'false' ? false : true;
        var $allowClear = element.attr('data-column-nullable') == 'true' ? true : false;
        var $dependencies = JSON.parse(element.attr('data-dependencies'));
        var $ajaxDelay = element.attr('data-ajax-delay');
        var $isFieldInline = element.data('field-is-inline');
        var $fieldCleanName = element.attr('data-repeatable-input-name') ?? element.attr('name');

        if ($(element).hasClass('select2-hidden-accessible')) {
            return;
        }

        $(element).select2({
            theme: 'bootstrap',
            multiple: false,
            placeholder: $placeholder,
            minimumInputLength: $minimumInputLength,
            allowClear: $allowClear,
            dropdownParent: $isFieldInline ? $('#inline-create-dialog .modal-content') : $(document.body),
            ajax: {
                url: $dataSource,
                type: $method,
                dataType: 'json',
                delay: $ajaxDelay,
                data: function (params) {
                    if ($includeAllFormFields) {
                        return {
                            q: params.term,
                            page: params.page,
                            form: form.serializeArray(),
                            triggeredBy: {
                                'rowNumber': element.attr('data-row-number') !== 'undefined' ? element.attr('data-row-number') - 1 : false,
                                'fieldName': $fieldCleanName
                            }
                        };
                    }

                    return {
                        q: params.term,
                        page: params.page,
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;

                    let paginate = false;

                    if (data.data) {
                        paginate = data.next_page_url !== null;
                        data = data.data;
                    }

                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: processStateItemText(item, $fieldAttribute),
                                id: item[$connectedEntityKeyName],
                            };
                        }),
                        pagination: {
                            more: paginate,
                        }
                    };
                },
                cache: true
            },
        });

        for (var i = 0; i < $dependencies.length; i++) {
            var $dependency = $dependencies[i];

            if (typeof element.attr('data-custom-selector') == 'undefined') {
                form.find('[name="' + $dependency + '"], [name="' + $dependency + '[]"]').change(function () {
                    $(element.find('option:not([value=""])')).remove();
                    element.val(null).trigger('change');
                });
            } else {
                let rowNumber = element.attr('data-row-number');
                let selector = element.attr('data-custom-selector');

                selector = selector
                    .replaceAll('%DEPENDENCY%', $dependency)
                    .replaceAll('%ROW%', rowNumber);

                $(selector).change(function () {
                    $(element.find('option:not([value=""])')).remove();
                    element.val(null).trigger('change');
                });
            }
        }
    }

    if (typeof processStateItemText !== 'function') {
        function processStateItemText(item, $fieldAttribute) {
            var $appLang = '{{ app()->getLocale() }}';
            var $appLangFallback = '{{ Lang::getFallback() }}';
            var $emptyTranslation = '{{ trans('backpack::crud.empty_translations') }}';
            var $itemField = item[$fieldAttribute];

            return typeof $itemField === 'object' && $itemField !== null
                ? $itemField[$appLang] ? $itemField[$appLang] : $itemField[$appLangFallback] ? $itemField[$appLangFallback] : Object.values($itemField)[0] ? Object.values($itemField)[0] : $emptyTranslation
                : $itemField;
        }
    }
</script>
@endLoadOnce
@endpush

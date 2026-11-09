<!-- checklist -->
@php
    $unique_id = uniqid();
    $model = new $field['model']();
    $key_attribute = $model->getKeyName();
    $identifiable_attribute = $field['attribute'];

    // calculate the checklist options
    if (!isset($field['options'])) {
        $field['options'] = $field['model']
            ::orderBy('name', 'ASC')
            ->pluck($identifiable_attribute, $key_attribute)
            ->toArray();
    } else {
        $field['options'] = call_user_func($field['options'], $field['model']::query());
    }

    // calculate the value of the hidden input
    $field['value'] = old(square_brackets_to_dots($field['name'])) ?? ($field['value'] ?? ($field['default'] ?? []));
    if ($field['value'] instanceof Illuminate\Database\Eloquent\Collection || $field['value'] instanceof Illuminate\Support\Collection) {
        $field['value'] = $field['value']->pluck($key_attribute)->toArray();
    } elseif (is_string($field['value'])) {
        $field['value'] = json_decode($field['value']);
    }

    // define the init-function on the wrapper
    $field['wrapper']['data-init-function'] = $field['wrapper']['data-init-function'] ?? 'bpFieldInitChecklist';

    $options = [];

    foreach ($field['options'] as $key => $option) {
        $group = explode('.', $option, 2);
        $options[$group[0]][$key] = $option;
    }
@endphp

@include('crud::fields.inc.wrapper_start')
<div class="d-flex justify-content-between">
    <label>{!! $field['label'] !!}</label>
    <a href="javascript:void(0);" class="my-2 font-weight-bold" type="button" data-toggle="collapse"
       data-target=".collapse" aria-expanded="false">
        <span data-toggle="tooltip" data-placement="top" title="Expand/Collapse">
            <i class="la la-angle-double-down" style="font-weight: 600; font-size: 1.2rem"></i>
            <i class="la la-angle-double-up" style="font-weight: 600; font-size: 1.2rem"></i>
        </span>
    </a>
</div>
@include('crud::fields.inc.translatable_icon')

<input type="hidden" value='@json($field['value'])' name="{{ $field['name'] }}">
{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif

<div class="row mr-1" style="max-height: 60vh; overflow-y: scroll">
    @foreach ($options as $key => $option_group)
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header py-2 px-3">
                    <div class="d-flex justify-content-between">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input all-permission-check pmsn-title"
                                   value="{{ str_replace(".", "-", $key) }}"
                                   id="permission-group-{{ $key.'-'.$unique_id }}">
                            <label class="form-check-label font-weight-bold"
                                   for="permission-group-{{ $key.'-'.$unique_id }}">
                                {{ ucwords(str_replace("-", " ", $key)) }}
                            </label>
                        </div>
                        <a href="javascript:void(0);" class="text-dark"
                           data-toggle="collapse"
                           data-target="#collapse-{{ str_replace(".", "-", $key) }}"
                           aria-expanded="true"
                           aria-controls="collapse-{{ str_replace(".", "-", $key) }}">
                            <i class="la la-angle-double-down" style="font-weight: 600; font-size: 1.2rem"></i>
                        </a>
                    </div>

                    <div id="collapse-{{ str_replace(".", "-", $key) }}" class="collapse">
                        <div class="card-body row px-0 py-2">
                            @foreach($option_group as $value => $label)
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 my-1">
                                    <div class="form-check">
                                        <input type="checkbox" value="{{ $value }}"
                                               data-title="{{ str_replace(".", "-", $key) }}"
                                               class="pmsn form-check-input {{$key}}" id="permission-{{ $label.'-'.$unique_id }}">
                                        <label class="form-check-label" for="permission-{{ $label.'-'.$unique_id }}">
{{--                                            {{ ucwords(str_replace(['.', '-', 'show'], [' ', ' ', 'detail'], $label)) }}--}}
                                            {{ ucwords(str_replace('-', ' ', explode('.', $label)[1])) }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@include('crud::fields.inc.wrapper_end')


{{-- ########################################## --}}
{{-- Extra CSS and JS for this particular field --}}
{{-- If a field type is shown multiple times on a form, the CSS and JS will only be loaded once --}}
@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp
    {{-- FIELD JS - will be loaded in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            function initCheckboxes(element, checkboxes, hidden_input, selected_options) {
                checkboxes.each(function (key, option) {
                    var id = $(option).val();
                    if (selected_options.map(String).includes(id)) {
                        $(option).prop('checked', 'checked');
                    } else {
                        $(option).prop('checked', false);
                    }
                });

                changeCheckBoxes(element, checkboxes, hidden_input);
            }

            function changeCheckBoxes(element, checkboxes, hidden_input) {
                var newValue = [];
                let all_permission_titles = [];
                let active_permission_titles = [];
                let label;

                checkboxes.each(function (key, element) {
                    const item = $(element);

                    if (label != item.data('title')){
                        label = item.data('title');
                        all_permission_titles.push(label);
                        active_permission_titles.push(label);
                    }

                    if (item.is(':checked')) {
                        var id = item.val();
                        newValue.push(id);
                    }

                    if (active_permission_titles.includes(label) && !item.is(':checked')){
                        active_permission_titles.pop(label);
                    }
                });

                hidden_input.val(JSON.stringify(newValue));

                all_permission_titles.forEach(function(title) {
                    if (active_permission_titles.includes(title)) {
                        element.find(`input[value=${title}].pmsn-title`).prop('checked', 'checked');
                    } else {
                        element.find(`input[value=${title}].pmsn-title`).prop('checked', false);
                    }
                });
            }

            function bpFieldInitChecklist(element) {
                let hidden_input = element.find('input[type=hidden]');
                let selected_options = JSON.parse(hidden_input.val() || '[]');
                let checkboxes = element.find('input[type=checkbox].pmsn');
                let title_checkboxes = element.find('input[type=checkbox].pmsn-title');

                // set the default checked/unchecked states on checklist options
                initCheckboxes(element, checkboxes, hidden_input, selected_options);

                // when a checkbox is clicked
                // set the correct value on the hidden input
                checkboxes.click(function () {
                    changeCheckBoxes(element, checkboxes, hidden_input);
                });

                title_checkboxes.click(function () {
                    let child_class_name = $(this).val();
                    element.find(`input[data-title=${child_class_name}].pmsn`).prop('checked', $(this).is(':checked'));
                    changeCheckBoxes(element, checkboxes, hidden_input);
                });
            }
        </script>
    @endpush
@endif
{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}

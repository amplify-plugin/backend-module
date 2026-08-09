@php
    $field['value'] = trim(old_empty_or_null($field['name'], '') ?? ($field['value'] ?? ($field['default'] ?? '')));

    $id = $field['attributes']['id'] ?? ($field['name'].'-'.mt_rand(1,9).'-code');

    $field['attributes']['id'] = $id;
@endphp

@include('crud::fields.inc.wrapper_start')
<label for="{{ $id }}">{!! $field['label'] !!}</label>

<div style="display: block; width: 100%" id="app">
    <textarea
            name="{{ $field['name'] }}"
            ref="{{ $field['name'] }}"
            style="display:none;"
    @include('crud::fields.inc.attributes')
    >{{ $field['value'] ?? '' }}</textarea>
    <code-field target="#{{$id}}"/>
</div>
{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif

@include('crud::fields.inc.wrapper_end')

{{-- CUSTOM CSS --}}
@push('crud_fields_styles')
    {{-- How to add some CSS? --}}
    @loadOnce('code_field_style')
    <style>
        .my-editor {
            background: #2d2d2d;
            color: #ccc !important;
            font-family: Consolas, Menlo, Courier, monospace;
            font-size: 14px;
            line-height: 1.5;
            padding: 5px;
            border-radius: 4px !important;
            min-height: 350px !important;
        }

        pre.prism-editor__editor {
            color: #ffc107 !important;
        }

        .prism-editor__container > textarea {
            display: none;
        }
    </style>
    @endLoadOnce
@endpush

{{-- CUSTOM JS --}}
@push('crud_fields_scripts')
    {{-- How to add some JS to the field? --}}
    @loadOnce('bpFieldInitDummyFieldElement')
    <script src="{{  mix("js/backend.js", "vendor/backend") }}"></script>
    @endLoadOnce
@endpush

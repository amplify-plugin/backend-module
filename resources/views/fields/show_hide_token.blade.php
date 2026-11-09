<!-- password -->

@php
    // autocomplete off, if not otherwise specified
    if (!isset($field['attributes']['autocomplete'])) {
        $field['attributes']['autocomplete'] = "off";
    }
    $rand = mt_rand(1000, 9999);
@endphp

@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')
<div class="d-flex btn-group custom-password">
    <input
        type="text"
        name="{{ $field['name'] }}"
        id="api_token_{{ $rand }}"
        value="{{ old_empty_or_null($field['name'], '') ??  $field['value'] ?? $field['default'] ?? '' }}"
        @include('crud::fields.inc.attributes')
    >
    <span id="show_password" class="mt-2 mr-2 "
          style="position: absolute; top: 0; right: 5px; transition: right 0.2s;">
            <i class="la la-recycle my-auto"></i>
        </span>
</div>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
<style>
    .text-danger > .custom-password > .form-control {
        border: 1px solid #df4759;
    }
</style>
@include('crud::fields.inc.wrapper_end')

@section('after_scripts')
    <script>
        function generateRandomString(length) {
            let result = '';
            const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            const charactersLength = characters.length;
            for (let i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
        $(function () {
            $('#show_password').click(function () {
                let field = $('#api_token_{{ $rand }}');
                field.val(btoa(generateRandomString(40)));
            });
        });
    </script>
@endsection

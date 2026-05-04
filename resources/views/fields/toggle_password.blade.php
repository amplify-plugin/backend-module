<!-- password -->

@php
    // autocomplete off, if not otherwise specified
    if (!isset($field['attributes']['autocomplete'])) {
        $field['attributes']['autocomplete'] = "off";
    }
@endphp

@include('crud::fields.inc.wrapper_start')
    <label>{!! $field['label'] !!}</label>
    @include('crud::fields.inc.translatable_icon')
    <div class="d-flex btn-group show-hide-password">
        <input
            type="password"
            name="{{ $field['name'] }}"
            @include('crud::fields.inc.attributes')
        />
        <span class="mt-2" style="position: absolute; top: 0; right: 5px; transition: right 0.2s;">
            <i class="la la-eye-slash my-auto show-hide-btn"></i>
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
    .show-hide-password {
        cursor: pointer;
    }
</style>
@include('crud::fields.inc.wrapper_end')

{{-- FIELD JS - will be loaded in the after_scripts section --}}
@push('crud_fields_scripts')
    @loadOnce('show_hide_password_field')
    <script>
        let name       = "{{ $field['name'] }}";
        let target     = $(`.show-hide-password`);

        target.on('click', (event) => {
            let e_target = $(event.target);
            let target = $(event.currentTarget);

            if (e_target.hasClass('show-hide-btn')) {
                let input = target.children('input');
                if(input.attr('type') === 'text') {
                    input.attr('type', 'password');
                    e_target.removeClass('la-eye-slash').addClass('la-eye');
                }else {
                    input.attr('type', 'text');
                    e_target.addClass('la-eye-slash').removeClass('la-eye');
                }
            }
        })
    </script>
    @endLoadOnce
@endpush

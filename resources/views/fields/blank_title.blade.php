<!-- text input -->
@include('crud::fields.inc.wrapper_start')
    <h4>{!! $field['label'] !!}</h4>
    @include('crud::fields.inc.translatable_icon')

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

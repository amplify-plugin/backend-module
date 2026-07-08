@php
    $value = data_get($entry, $column['name']);
    $column['escaped'] = $column['escaped'] ?? false;
@endphp

<button class="btn btn-primary large_text_toggle_button">Show Content</button>
<div class="large_text d-none">
    @if($column['escaped'])
        {{ $value }}
    @else
        {!! $value !!}
    @endif
</div>
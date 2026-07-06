{{-- regular object attribute --}}
@php
    $value = data_get($entry, $column['name']);
@endphp
<iframe src="{{ backpack_url('mail-log/preview-mail/'.$entry->id) }}" frameborder="0"
        style="width: 100%; height: 70vh; overflow: scroll;"></iframe>

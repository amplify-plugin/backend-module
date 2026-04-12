{{-- regular object attribute --}}
@php
    $default = ucwords(Str::replace(['_', '-'], ' ',$entry->option));
    $column['value'] = $column['value'] ?? data_get($entry, 'field.label');
    if (in_array($column['value'], ['Value', 'value'])) {
        $column['value'] = $default;
    }
    $column['text'] = $column['default'] ?? '-';

    if($column['value'] instanceof \Closure) {
        $column['value'] = $column['value']($entry);
    }

    if(is_array($column['value'])) {
        $column['value'] = json_encode($column['value']);
    }

    if(!empty($column['value'])) {
        $column['text'] = $column['value'];
    }
@endphp

<span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
    {{ $column['text'] }}
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
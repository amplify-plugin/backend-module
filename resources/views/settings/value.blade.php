@php
    $value = $value ?? data_get($entry, $column['name']);

    $value = match (true) {
        $value instanceof \Closure => $value($entry),
        default => \Amplify\System\Helpers\UtilityHelper::typeCast($value, $entry->type)
    };

    if(is_array($value)) {
        $value = json_encode($value);
    }

    $fieldType = match($entry->field['type']) {
        'url' => 'text',
        default => $entry->field['type'] ?? 'text'
    };
    $field = $entry->field ?? [];
    unset($field['value'], $field['default']);
    $column = array_merge($column, $field);
@endphp

@include("crud::columns.{$fieldType}")

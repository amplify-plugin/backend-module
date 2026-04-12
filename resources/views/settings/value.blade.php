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
        'ckeditor' => 'text',
        'browse', 'url' => 'view',
        default => $entry->field['type'] ?? 'text'
    };
    $field = $entry->field ?? [];
    unset($field['value'], $field['default']);
    $column = array_merge($column, $field);
    if ($fieldType == 'view') {
        $column['view'] = 'backend::settings.link';
    }
@endphp

@include("crud::columns.{$fieldType}")

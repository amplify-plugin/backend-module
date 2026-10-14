@php
    $value = $value ?? data_get($entry, $column['name']);

    $value = match (true) {
        $value instanceof \Closure => $value($entry),
        default => \Amplify\System\Helpers\UtilityHelper::typeCast($value, $entry->type)
    };

    if(is_array($value)) {
        $value = json_encode($value);
    }

    if (empty($entry->field)) {
        $entry->field['type'] = 'text';
    }

    $viewPath = match($entry->field['type']) {
        'ckeditor' => 'crud::columns.text',
        'browse', 'url' => 'backend::settings.link',
        'select2_from_ajax' => 'backend::settings.model',
        default => str_contains($entry->field['type'], '::') ? $entry->field['type'] : "crud::columns.{$entry->field['type']}"
    };
    $field = $entry->field ?? [];
    unset($field['value'], $field['default']);
    $column = array_merge($column, $field);
@endphp

@include($viewPath)

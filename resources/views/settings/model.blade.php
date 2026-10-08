@if(empty($column['model']))
    <span class="text-muted">Please write a full model class with namespace.</span>

@elseif(!class_exists($column['model']))
    <span class="text-muted">`{{ $column['model'] }}` model class does not exist.</span>
@else
    @php
        $column['value'] = $column['value'] ?? data_get($entry, $column['name']);
        $column['text'] = $column['default'] ?? '-';

        if(is_array($column['value'])) {
            $column['value'] = json_encode($column['value']);
        }

        if(!empty($column['value'])) {
            $model = $column['model']::find($column['value']);
            $column['text'] = data_get($model, $column['attribute'],'-');
        }
    @endphp

    <span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        {!! $column['text'] !!}
        @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
@endif


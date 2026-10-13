@php
    $value = data_get($entry, $column['name']);

    if (is_string($value)) {
        $value = json_decode($value, true);
    }

    $additional = [];

    $collectAdditional = function ($data, $section = null) use (&$collectAdditional, &$additional) {
        if (! is_array($data)) {
            return;
        }

        foreach ($data as $key => $item) {
            if ($key === 'additional' && is_array($item)) {
                foreach ($item as $entry) {
                    $additional[] = ['section' => $section] + (array) $entry;
                }
            } elseif (is_array($item)) {
                $collectAdditional($item, is_string($key) ? $key : $section);
            }
        }
    };

    $collectAdditional($value);
@endphp

<span>
    @if (!empty($additional))

        @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')

        <table class="table table-bordered table-condensed table-striped m-b-0">
            <thead>
                <tr>
                    <th>{{ __('Section') }}</th>
                    <th>{{ __('Label') }}</th>
                    <th>{{ __('Field') }}</th>
                    <th>{{ __('Value') }}</th>
                    <th>{{ __('Source') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($additional as $row)
                    <tr>
                        <td>{{ ucfirst($row['section']) }}</td>
                        <td>{{ $row['label'] ?? '' }}</td>
                        <td>{{ $row['field'] ?? '' }}</td>
                        <td>
                            @if (is_array($row['value'] ?? null))
                                <pre class="m-0">{{ json_encode($row['value'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            @else
                                {{ $row['value'] ?? '-' }}
                            @endif
                        </td>
                        <td>{{ $row['source'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')

    @else

        {{ $column['default'] ?? '-' }}

    @endif
</span>

{{-- image column type --}}
@php
    $value = data_get($entry, $column['name']);

    if($value && count($value)) {
      $column['height'] = $column['height'] ?? "25px";
      $column['width'] = $column['width'] ?? "auto";
      $column['radius'] = $column['radius'] ?? "3px";
      $column['prefix'] = $column['prefix'] ?? '';

      $column['wrapper']['element'] = $column['wrapper']['element'] ?? 'a';
      $column['wrapper']['target'] = $column['wrapper']['target'] ?? '_blank';
    }
@endphp

<span>
    @if ($value && count($value))
        @foreach ($value as $file_path)
            @php
                $src = $column['prefix'].$file_path;
            @endphp
            @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
            <img src="{{ assets_image($src) }}" style="
                    max-height: {{ $column['height'] }};
                    width: {{ $column['width'] }};
                    border-radius: {{ $column['radius'] }};"
                 class="mr-2"
            />
            @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
        @endforeach
    @else
        -
    @endif
</span>

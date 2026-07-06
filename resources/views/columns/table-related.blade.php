@php
	$value = data_get($entry, $column['name']);

    // make sure columns are defined
    if (!isset($column['columns'])) {
        $column['columns'] = ['value' => "Value"];
    }

	$columns = $column['columns'];

	// if this attribute isn't using attribute casting, decode it
	if (is_string($value)) {
	    $value = json_decode($value);
    }
@endphp

<span>
    @if ($value && count($columns))

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')

    <table class="table table-bordered table-condensed table-striped m-b-0">
		<thead>
			<tr>
				@foreach($columns as $tableColumn)
				<th>{{ $tableColumn['label'] ?? $tableColumn['name'] }}</th>
				@endforeach
			</tr>
		</thead>
		<tbody>
			@foreach ($value as $tableRow)
			<tr>
				@foreach($columns as $tableColumn)
					@php

						$cellValue = '';

						if( is_array($tableRow) && isset($tableRow[$tableColumn['name']]) ) 
						{
                            $cellValue = $tableRow[$tableColumn['name']];
						}
                        
						if( is_object($tableRow) )
						{
							if($tableColumn['type'] == 'closure' && isset($tableColumn['function'])) {
								$cellValue = $tableColumn['function']($tableRow);
							}
							else if(isset($tableColumn['entity']) && isset($tableColumn['attribute'])) {
								$cellValue = $tableRow->{$tableColumn['entity']}->{$tableColumn['attribute']} ?? '';
							}
							else if($tableColumn['type'] == 'model_function' && isset($tableColumn['function_name'])) {
								$cellValue = $tableRow->{$tableColumn['function_name']}() ?? '';
							}
							else {
								$cellValue = $tableRow->{$tableColumn['name']} ?? '';
							}
						}
                        
					@endphp
					<td>
						{!! $cellValue !!}
					</td>
				@endforeach
			</tr>
			@endforeach
		</tbody>
    </table>

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')

	@endif
</span>

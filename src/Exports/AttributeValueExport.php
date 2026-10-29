<?php

namespace Amplify\System\Backend\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttributeValueExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    private Collection $collection;

    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function collection(): Collection
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return [
            'Attribute Name',
            'Attribute Value',
            'Sequence',
        ];
    }
}

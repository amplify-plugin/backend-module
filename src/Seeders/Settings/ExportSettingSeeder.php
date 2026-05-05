<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExportSettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::where('name', 'export')->delete();

        foreach ($this->data() as $datum) {
            $datum['name'] = 'export';
            SystemConfiguration::create($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'export_max_limit',
                'value' => 10000,
                'type' => 'integer',
                'field' => [
                    'name' => 'value',
                    'type' => 'integer',
                    'label' => 'Export Max Limit',
                    'hint' => 'Maximum number of records to export at a time',
                ],
            ]
        ];
    }
}

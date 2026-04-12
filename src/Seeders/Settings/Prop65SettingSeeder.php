<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Prop65SettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::where('name', 'prop65')->delete();

        foreach ($this->data() as $datum) {
            $datum['name'] = 'prop65';
            SystemConfiguration::create($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'prop65_icon',
                'value' => null,
                'field' => [
                    'name' => 'value',
                    'type' => 'browse',
                    'label' => 'Select Icon File',
                ],
            ],
            [
                'option' => 'prop65_title',
                'value' => 'PROP 65 Warning',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Value',
                    'default' => 'PROP 65 Warning',
                ],
            ],
            [
                'option' => 'prop65_message',
                'value' => 'PROP 65 Warning',
                'field' => [
                    'name' => 'value',
                    'type' => 'ckeditor',
                    'label' => 'Value',
                ],
            ],
            [
                'option' => 'prop65_status',
                'value' => true,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Enabled?',
                    'default' => true,
                ],
            ],
        ];
    }
}

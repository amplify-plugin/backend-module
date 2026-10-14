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
        foreach ($this->data() as $datum) {
            $datum['name'] = 'prop65';
            SystemConfiguration::seed($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'prop65_icon',
                'value' => null,
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'browse',
                    'label' => 'Icon File',
                    'hint' => 'This is a visual representation of Prop65 warning message.'
                ],
            ],
            [
                'option' => 'prop65_title',
                'value' => 'PROP 65 Warning',
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Warning Title',
                    'default' => 'PROP 65 Warning Title',
                    'hint' => 'This title will be shown on the pop up of Prop65 Alert message.'
                ],
            ],
            [
                'option' => 'prop65_message',
                'value' => 'PROP 65 Warning',
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'ckeditor',
                    'label' => 'Warning Message',
                    'hint' => 'This description will be shown inside of the pop up of Prop65 Alert message.'
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
                    'hint' => 'If enabled and the item has a prop65 flagged then system will show the message.',
                ],
            ],
        ];
    }
}

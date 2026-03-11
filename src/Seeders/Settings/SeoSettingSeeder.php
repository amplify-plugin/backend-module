<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeoSettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //        SystemConfiguration::where('name', 'seo')->delete();
        //
        //        foreach ($this->data() as $datum) {
        //            $datum['name'] = 'seo';
        //            SystemConfiguration::create($datum);
        //        }
    }

    private function data()
    {
        return [
            [
                'option' => 'prop65_icon',
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'browse',
                    'label' => 'Select Icon File',
                ],
            ],
            [
                'option' => 'prop65_title',
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Value',
                    'default' => 'PROP 65 Warning',
                ],
            ],
            [
                'option' => 'prop65_message',
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'ckeditor',
                    'label' => 'Value',
                ],
            ],
            [
                'option' => 'prop65_status',
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

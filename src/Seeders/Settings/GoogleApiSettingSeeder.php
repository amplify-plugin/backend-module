<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class GoogleApiSettingSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::where('name', 'google')->delete();

        foreach ($this->data() as $datum) {
            $datum['name'] = 'google';
            SystemConfiguration::create($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'google_map_api_key',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Google Map API Key'
                ],
            ],
            [
                'option' => 'google_analytics_id',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Google Analytics ID'
                ],
            ],
            [
                'option' => 'google_tag_manager_id',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Google Tag Manager ID'
                ],
            ],
            [
                'option' => 'google_analytics_url',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'url',
                    'label' => 'Google Analytics URL'
                ],
            ]
        ];
    }
}

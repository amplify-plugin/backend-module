<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $datum) {
            $datum['name'] = 'report';
            SystemConfiguration::seed($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'protocol',
                'value' => 'https',
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Host Protocol',
                    'default' => 'http',
                    'options' => [
                        'http' => 'HTTP',
                        'https' => 'HTTPS'
                    ],
                    'hint' => 'The protocol will be use to connect to reporting instance.'
                ],
            ],
            [
                'option' => 'host',
                'value' => null,
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Hostname',
                    'hint' => 'URL that will be use to connect the reporting instance.'
                ],
            ],
            [
                'option' => 'port',
                'value' => null,
                'type' => 'integer',
                'field' => [
                    'name' => 'value',
                    'type' => 'number',
                    'attributes' => [
                        'min' => 1,
                        'max' => 65535,
                        'step' => 1,
                    ],
                    'label' => 'Port',
                    'hint' => 'The port will be use to connect to the reporting instance.'
                ],
            ],
            [
                'option' => 'dictionary',
                'value' => true,
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Dictionary Name',
                    'hint' => 'Dictionary from where all the query will be executed in the reporting instance.',
                ],
            ],
        ];
    }
}

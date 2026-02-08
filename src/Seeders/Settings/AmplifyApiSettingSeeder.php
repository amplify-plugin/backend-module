<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class AmplifyApiSettingSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::where('name', 'api')->delete();

        foreach ($this->data() as $datum) {
            $datum['name'] = 'api';
            SystemConfiguration::create($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'contact_detail',
                'type' => 'bool',
                'value' => false,
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'default' => false,
                    'label' => 'Enable Contact Detail API',
                ],
            ],
            [
                'option' => 'contact_id_key',
                'value' => 'id',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Contact Lookup Field',
                    'default' => 'id',
                    'options' => [
                        'id' => 'Database ID Number',
                        'contact_code' => 'Contact Erp Code',
                        'email' => 'Email Address',
                        'phone' => 'Phone Number',
                    ],
                ],
            ],
        ];
    }
}

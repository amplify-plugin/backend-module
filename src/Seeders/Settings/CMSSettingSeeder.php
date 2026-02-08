<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class CMSSettingSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::where('name', 'cms')->delete();

        foreach ($this->data() as $datum) {
            $datum['name'] = 'cms';
            SystemConfiguration::create($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'slogan',
                'value' => 'Amplify Your Online Business',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Topbar Tagline',
                ],
            ],
            [
                'option' => 'email',
                'value' => 'example@example.com',
                'field' => [
                    'name' => 'value',
                    'type' => 'email',
                    'label' => 'Contact Email',
                ],
            ],
            [
                'option' => 'phone',
                'value' => '+(000)00-000-000',
                'field' => [
                    'name' => 'value',
                    'type' => 'phone',
                    'label' => 'Contact Phone',
                    'config' => [
                        'initialCountry' => 'us',
                        'separateDialCode' => true,
                        'nationalMode' => true,
                        'autoHideDialCode' => false,
                        'placeholderNumberType' => 'MOBILE',
                    ]
                ],
            ],
            [
                'option' => 'logo_path',
                'type' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'browse',
                    'label' => 'Select Brand Logo File',
                ],
            ],
            [
                'option' => 'favicon_path',
                'type' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'browse',
                    'label' => 'Select Favicon Logo File',
                ],
            ],

        ];
    }
}

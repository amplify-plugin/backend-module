<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class InvoiceSettingSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::where('name', 'invoice')->delete();

        foreach ($this->data() as $datum) {
            $datum['name'] = 'invoice';
            SystemConfiguration::create($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'header_content_type',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Invoice Header Content Type',
                    'options' => [
                        'html' => 'HTML',
                        'image' => 'Image',
                    ],
                ],
            ],
            [
                'option' => 'header_content',
                'field' => [
                    'name' => 'value',
                    'type' => 'ckeditor',
                    'label' => 'Value',
                    'hint' => 'Invoice Header Content',
                ],
            ],
            [
                'option' => 'header_image_path',
                'type' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'browse',
                    'label' => 'Select Header Image',
                ],
            ],
            [
                'option' => 'footer_content_type',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Invoice Footer Content Type',
                    'options' => [
                        'html' => 'HTML',
                        'image' => 'Image',
                    ],
                ],
            ],
            [
                'option' => 'footer_image_path',
                'type' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'browse',
                    'label' => 'Select Footer Image',
                ],
            ],
            [
                'option' => 'footer_content',
                'field' => [
                    'name' => 'value',
                    'type' => 'ckeditor',
                    'label' => 'Value',
                    'hint' => 'Invoice Footer Content',
                ],
            ],
        ];
    }
}

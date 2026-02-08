<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class SecuritySettingSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::where('name', 'security')->delete();

        foreach ($this->data() as $datum) {
            $datum['name'] = 'security';
            SystemConfiguration::create($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'force_password_reset_enabled',
                'value' => true,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'default' => true,
                    'label' => 'Enable Force Password Reset',
                    'hint' => 'If enabled system will ask user to reset password, if changed by admin.',
                ],
            ],
            [
                'option' => 'password_length',
                'value' => 4,
                'field' => [
                    'name' => 'value',
                    'type' => 'number',
                    'label' => 'Value',
                    'default' => 4,
                    'hint' => 'Minimum password length for whole system validation.',
                ],
            ],
            [
                'option' => 'cookie_title',
                'value' => 'We value your privacy',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Value',
                    'default' => 'We value your privacy',
                    'hint' => 'Title want to show for GDPR compliance policy concern pop-up.',
                ],
            ],
            [
                'option' => 'cookie_content',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'ckeditor',
                    'label' => 'Value',
                    'default' => <<<'HTML'
                    <p>This website stores cookies on your computer. These cookies are used to improve your website experience and provide more personalized services to you, both on this website and through other media. To find out more about the cookies we use, see our Privacy Policy.</p>
<br>
<p>We won't track your information when you visit our site. But in order to comply with your preferences, we'll have to use just one tiny cookie so that you're not asked to make this choice again.</p>
HTML,
                    'hint' => 'Body message of the GDPR compliance policy Concern pop-up.',
                ],
            ],
            [
                'option' => 'skip_contact_approval',
                'type' => 'bool',
                'value' => true,
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Enabled?',
                    'default' => true,
                    'hint' => 'If enabled registered contact/account able to login without approval.',
                ],
            ],
            [
                'option' => 'captcha_type',
                'value' => 'flat',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Value',
                    'default' => 'math',
                    'options' => [
                        'math' => 'Math',
                        'flat' => 'Flat',
                        'inverse' => 'Inverse',
                        'small' => 'Small',
                    ],
                ],
            ],
        ];
    }
}

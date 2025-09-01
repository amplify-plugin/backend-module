<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\SystemConfiguration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system_configurations')->truncate();

        $system_configurations = $this->data();

        foreach ($system_configurations as $group => $configs) {
            foreach ($configs as $config) {
                SystemConfiguration::setValue($config['name'], $config['option'], $config['value'], $config['type']);
            }
        }
    }

    private function data()
    {
        return [
            'basic' => [
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'global_currency',
                    'value' => 'USD',
                ],
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'default_language',
                    'value' => 'en',
                ],
                [
                    'name' => 'basic',
                    'type' => 'json',
                    'option' => 'hierarchies',
                    'value' => ['Category', 'ProductClassification'],
                ],
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'web_order_prefix',
                    'value' => null,
                ],
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'nxt_available_web_order_number',
                    'value' => '0000001',
                ],
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'project_mode',
                    'value' => 'developer',
                ],
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'is_elfinder_drag_and_drop',
                    'value' => null,
                ],
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'date_time_format',
                    'value' => 'Y-m-d H:i:s',
                ],
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'date_format',
                    'value' => 'd M, Y',
                ],
                [
                    'name' => 'basic',
                    'type' => 'integer',
                    'option' => 'default_reorder_limit',
                    'value' => 10,
                ],
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'navbar_brand',
                    'value' => 'img/Amplify Logo 280 tagline.png',
                ],
                [
                    'name' => 'basic',
                    'type' => 'string',
                    'option' => 'footer_image',
                    'value' => 'img/Powered by EasyAsk.png',
                ],
            ],
            'pim' => [
                [
                    'name' => 'pim',
                    'type' => 'bool',
                    'option' => 'auto_publish',
                    'value' => false,
                ],
                [
                    'name' => 'pim',
                    'type' => 'bool',
                    'option' => 'required_fields',
                    'value' => true,
                ],
                [
                    'name' => 'pim',
                    'type' => 'bool',
                    'option' => 'use_classifications',
                    'value' => false,
                ],
                [
                    'name' => 'pim',
                    'type' => 'bool',
                    'option' => 'categorization_required',
                    'value' => true,
                ],
                [
                    'name' => 'pim',
                    'type' => 'json',
                    'option' => 'mandatory_fields',
                    'value' => [],
                ],
            ],
            'search' => [
                [
                    'name' => 'search',
                    'type' => 'string',
                    'option' => 'product_search_by_id_prefix',
                    'value' => 'Products.Product Id',
                ],
                [
                    'name' => 'search',
                    'type' => 'string',
                    'option' => 'easyask_host',
                    'value' => 'demoV16.easyaskondemand.com',
                ],
                [
                    'name' => 'search',
                    'type' => 'string',
                    'option' => 'easyask_port',
                    'value' => null,
                ],
                [
                    'name' => 'search',
                    'type' => 'string',
                    'option' => 'protocol',
                    'value' => 'http',
                ],
                [
                    'name' => 'search',
                    'type' => 'string',
                    'option' => 'easyask_dictionary',
                    'value' => 'amplify-demo',
                ],
            ],
            'sayt' => [
                [
                    'name' => 'sayt',
                    'type' => 'string',
                    'option' => 'sayt_product_id',
                    'value' => null,
                ],
                [
                    'name' => 'sayt',
                    'type' => 'string',
                    'option' => 'sayt_product_image',
                    'value' => null,
                ],
                [
                    'name' => 'sayt',
                    'type' => 'string',
                    'option' => 'sayt_product_name',
                    'value' => null,
                ],
                [
                    'name' => 'sayt',
                    'type' => 'string',
                    'option' => 'sayt_product_price',
                    'value' => null,
                ],
                [
                    'name' => 'sayt',
                    'type' => 'string',
                    'option' => 'sayt_product_description',
                    'value' => null,
                ],
                [
                    'name' => 'sayt',
                    'type' => 'string',
                    'option' => 'sayt_product_type',
                    'value' => null,
                ],
                [
                    'name' => 'sayt',
                    'type' => 'string',
                    'option' => 'sayt_product_sizes',
                    'value' => null,
                ],
            ],
            'icecat' => [
                [
                    'name' => 'icecat',
                    'type' => 'string',
                    'option' => 'icecat_username',
                    'value' => 'raitken@easyask.com',
                ],
            ],
            'google' => [
                [
                    'name' => 'google',
                    'type' => 'string',
                    'option' => 'google_map_api_key',
                    'value' => '',
                ],
                [
                    'name' => 'google',
                    'type' => 'string',
                    'option' => 'google_analytics_id',
                    'value' => '',
                ],
                [
                    'name' => 'google',
                    'type' => 'string',
                    'option' => 'google_analytics_url',
                    'value' => '',
                ],

            ],
            'frontend' => [
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'front_page_id',
                    'value' => 35,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'shop_page_id',
                    'value' => 36,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'product_page_id',
                    'value' => 67,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'string',
                    'option' => 'easyask_single_product_index',
                    'value' => 'product_slug',
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'order_details_page_id',
                    'value' => 51,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'quotation_details_page_id',
                    'value' => 49,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'invoice_details_page',
                    'value' => 77,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'order_list_items_page_id',
                    'value' => 54,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'quotation_page_id',
                    'value' => 50,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'order_list_page_id',
                    'value' => 55,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'customer_login_page_id',
                    'value' => 60,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'customer_registration_page_id',
                    'value' => 59,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'customer_dashboard_page_id',
                    'value' => 45,
                ],
                [
                    'name' => 'frontend',
                    'type' => 'integer',
                    'option' => 'order_page_id',
                    'value' => 53,
                ],
            ],
            'payment' => [
                [
                    'name' => 'payment',
                    'type' => 'string',
                    'option' => 'default',
                    'value' => 'cenpos',
                ],
                [
                    'name' => 'payment',
                    'type' => 'bool',
                    'option' => 'allow_credit_payments',
                    'value' => true,
                ],
                [
                    'name' => 'payment',
                    'type' => 'bool',
                    'option' => 'allow_payments',
                    'value' => true,
                ],

                [
                    'name' => 'payment',
                    'type' => 'string',
                    'option' => 'gateways.default.merchant_id',
                    'value' => null,
                ],
                [
                    'name' => 'payment',
                    'type' => 'string',
                    'option' => 'gateways.default.payment_url',
                    'value' => null,
                ],
                [
                    'name' => 'payment',
                    'type' => 'string',
                    'option' => 'gateways.default.cenpos_encrypted_mid',
                    'value' => null,
                ],
                [
                    'name' => 'payment',
                    'type' => 'string',
                    'option' => 'gateways.default.secret_key',
                    'value' => null,
                ],

                [
                    'name' => 'payment',
                    'type' => 'string',
                    'option' => 'gateways.cenpos.merchant_id',
                    'value' => '400002917',
                ],
                [
                    'name' => 'payment',
                    'type' => 'string',
                    'option' => 'gateways.cenpos.payment_url',
                    'value' => 'https://www.cenpos.net/simplewebpay/cards/',
                ],
                [
                    'name' => 'payment',
                    'type' => 'string',
                    'option' => 'gateways.cenpos.cenpos_encrypted_mid',
                    'value' => 'UyaLhXyggZhyyxbnAzVYKg==',
                ],
                [
                    'name' => 'payment',
                    'type' => 'string',
                    'option' => 'gateways.cenpos.secret_key',
                    'value' => '799b27ae1463be856e1c54aa760b2c21ef3fe276d41067c38ce9cd7b8476aec3',
                ],
            ],
            'erp' => [
                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'default',
                    'value' => 'facts-erp',
                ],

                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'configurations.default.username',
                    'value' => null,
                ],
                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'configurations.default.url',
                    'value' => 'http://internal.mwd1.com/api',
                ],
                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'configurations.default.password',
                    'value' => null,
                ],
                [
                    'name' => 'erp',
                    'type' => 'bool',
                    'option' => 'configurations.default.multiple_warehouse',
                    'value' => true,
                ],
                [
                    'name' => 'erp',
                    'type' => 'bool',
                    'option' => 'configurations.default.enabled',
                    'value' => true,
                ],

                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'configurations.facts-erp.username',
                    'value' => 'SequoiaDEV',
                ],
                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'configurations.facts-erp.url',
                    'value' => 'http://internal.mwd1.com/api',
                ],
                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'configurations.facts-erp.password',
                    'value' => 'mwd1$SQ',
                ],
                [
                    'name' => 'erp',
                    'type' => 'bool',
                    'option' => 'configurations.facts-erp.multiple_warehouse',
                    'value' => true,
                ],
                [
                    'name' => 'erp',
                    'type' => 'bool',
                    'option' => 'configurations.facts-erp.enabled',
                    'value' => true,
                ],

                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'configurations.ecommerce-erp.username',
                    'value' => null,
                ],
                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'configurations.ecommerce-erp.url',
                    'value' => 'http://internal.mwd1.com/api',
                ],
                [
                    'name' => 'erp',
                    'type' => 'string',
                    'option' => 'configurations.ecommerce-erp.password',
                    'value' => null,
                ],
                [
                    'name' => 'erp',
                    'type' => 'bool',
                    'option' => 'configurations.ecommerce-erp.multiple_warehouse',
                    'value' => true,
                ],
                [
                    'name' => 'erp',
                    'type' => 'bool',
                    'option' => 'configurations.ecommerce-erp.enabled',
                    'value' => true,
                ],

            ],
            'invoice' => [
                [
                    'name' => 'invoice',
                    'type' => 'string',
                    'option' => 'header_content_type',
                    'value' => 'image',
                ],
                [
                    'name' => 'invoice',
                    'type' => 'string',
                    'option' => 'header_content',
                    'value' => null,
                ],
                [
                    'name' => 'invoice',
                    'type' => 'string',
                    'option' => 'header_image_path',
                    'value' => 'https://mountainwest.s3.amazonaws.com/images/banners/car-audio-banner-full-header.jpeg',
                ],
                [
                    'name' => 'invoice',
                    'type' => 'string',
                    'option' => 'footer_content',
                    'value' => '',
                ],
                [
                    'name' => 'invoice',
                    'type' => 'string',
                    'option' => 'footer_content_type',
                    'value' => 'html',
                ],
                [
                    'name' => 'invoice',
                    'type' => 'string',
                    'option' => 'footer_image_path',
                    'value' => null,
                ],
            ],
            'email' => [
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'default',
                    'value' => 'smtp',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'from.name',
                    'value' => null,
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'from.address',
                    'value' => null,
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'admin_email',
                    'value' => null,
                ],

                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.smtp.host',
                    'value' => 'smtp.mailtrap.io',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.smtp.username',
                    'value' => 'c3661e9c9d2981',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.smtp.password',
                    'value' => '659c031b49bca2',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.smtp.encryption',
                    'value' => 'tls',
                ],
                [
                    'name' => 'email',
                    'type' => 'integer',
                    'option' => 'mailers.smtp.port',
                    'value' => 9000,
                ],

                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.sendmail.host',
                    'value' => 'smtp.mailtrap.io',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.sendmail.username',
                    'value' => 'c3661e9c9d2981',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.sendmail.password',
                    'value' => '659c031b49bca2',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.sendmail.encryption',
                    'value' => 'tls',
                ],
                [
                    'name' => 'email',
                    'type' => 'integer',
                    'option' => 'mailers.sendmail.port',
                    'value' => 9000,
                ],

                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.mailgun.host',
                    'value' => 'smtp.mailtrap.io',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.mailgun.username',
                    'value' => 'c3661e9c9d2981',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.mailgun.password',
                    'value' => '659c031b49bca2',
                ],
                [
                    'name' => 'email',
                    'type' => 'string',
                    'option' => 'mailers.mailgun.encryption',
                    'value' => 'tls',
                ],
                [
                    'name' => 'email',
                    'type' => 'integer',
                    'option' => 'mailers.mailgun.port',
                    'value' => 9000,
                ],
            ],
            'cms' => [
                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'default',
                    'value' => null,
                ],

                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-1.logo',
                    'value' => null,
                ],
                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-1.email',
                    'value' => 'http://internal.mwd1.com/api',
                ],
                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-1.phone',
                    'value' => null,
                ],

                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-2.email',
                    'value' => 'SequoiaDEV',
                ],
                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-2.logo',
                    'value' => 'http://internal.mwd1.com/api',
                ],
                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-2.phone',
                    'value' => 'mwd1$SQ',
                ],

                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-3.email',
                    'value' => null,
                ],
                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-3.phone',
                    'value' => 'http://internal.mwd1.com/api',
                ],
                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-3.logo',
                    'value' => null,
                ],

                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-4.email',
                    'value' => null,
                ],
                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-4.phone',
                    'value' => 'http://internal.mwd1.com/api',
                ],
                [
                    'name' => 'cms',
                    'type' => 'string',
                    'option' => 'templates.template-4.logo',
                    'value' => null,
                ],

            ],
            'schedule' => [
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'time_zone',
                    'value' => 'UTC',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'bool',
                    'option' => 'commands.product_sync.enabled',
                    'value' => 'false',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.product_sync.interval',
                    'value' => 'daily',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'json',
                    'option' => 'commands.product_sync.variables',
                    'value' => '{"updateOnly":"N","processUpdates":"N","limit":null}',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.product_sync.time.minute',
                    'value' => '0',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.product_sync.time.hour',
                    'value' => '*',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.product_sync.time.day',
                    'value' => '*',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.product_sync.time.month',
                    'value' => '*',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.product_sync.time.weekday',
                    'value' => '*',
                ],

                [
                    'name' => 'schedule',
                    'type' => 'bool',
                    'option' => 'commands.hello_world.enabled',
                    'value' => 'false',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.hello_world.interval',
                    'value' => 'daily',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'json',
                    'option' => 'commands.hello_world.variables',
                    'value' => '{}',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.hello_world.time.minute',
                    'value' => '0',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.hello_world.time.hour',
                    'value' => '*',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.hello_world.time.day',
                    'value' => '*',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.hello_world.time.month',
                    'value' => '*',
                ],
                [
                    'name' => 'schedule',
                    'type' => 'string',
                    'option' => 'commands.hello_world.time.weekday',
                    'value' => '*',
                ],
            ],
        ];
    }
}

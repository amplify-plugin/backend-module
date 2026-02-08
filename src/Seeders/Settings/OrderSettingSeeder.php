<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class OrderSettingSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::where('name', 'order')->delete();

        foreach ($this->data() as $datum) {
            $datum['name'] = 'order';
            SystemConfiguration::create($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'order_rule_check',
                'value' => false,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Enable Order Rule Check?',
                    'hint' => 'If enabled a system will validate order restriction rules, before it send to ERP.'
                ],
            ],
            [
                'option' => 'send_email_to_create_order_from_quote',
                'value' => false,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Send Email to Create Order from Quote',
                    'hint' => 'If enabled System we can mail to salesperson when customer want an quote.'
                ],
            ],
            [
                'option' => 'use_pickup_enable_warehouses_as_shipping_methods',
                'value' => false,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Use Pickup Enable Warehouses as Shipping Methods',
                    'hint' => 'If enabled a system display pickup enabled warehouses as one of shipping options under pickup shipping method.'
                ],
            ],
        ];
    }
}

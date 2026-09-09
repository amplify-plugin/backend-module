<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\CustomerOrder;
use Amplify\System\Backend\Models\SystemConfiguration;
use Amplify\System\Helpers\UtilityHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SellingProductsSettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::query()->where('name', 'selling_products')->delete();

        foreach ($this->settings() as $datum) {
            $this->createSetting($datum);
        }
    }

    private function createSetting(array $datum): void
    {
        $type = $datum['type'] ?? 'string';

        SystemConfiguration::create([
            'name' => 'selling_products',
            'option' => $datum['option'],
            'type' => $type,
            'value' => UtilityHelper::stringify($type, $datum['value'] ?? null),
            'field' => $datum['field'] ?? null,
            'active' => true,
        ]);
    }

    private function settings(): array
    {
        return [
            [
                'option' => 'enabled',
                'value' => true,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Selling Products',
                    'hint' => 'When enabled, the Selling Products widget appears on the customer dashboard.',
                ],
            ],
            [
                'option' => 'products_limit',
                'value' => 10,
                'type' => 'integer',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Products to Display',
                    'options' => [
                        5 => '5',
                        10 => '10',
                        20 => '20',
                    ],
                    'hint' => 'Maximum number of top-selling products shown in the widget.',
                ],
            ],
            [
                'option' => 'date_range',
                'value' => 'last_60_days',
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Date Range',
                    'options' => [
                        'last_7_days' => 'Last 7 Days',
                        'last_30_days' => 'Last 30 Days',
                        'last_60_days' => 'Last 60 Days',
                        'last_90_days' => 'Last 90 Days',
                        'this_year' => 'This Year',
                        'custom' => 'Custom Date Range',
                    ],
                    'hint' => 'Default period used when aggregating selling products. Use Custom with the start/end date options below.',
                ],
            ],
            [
                'option' => 'custom_start_date',
                'value' => null,
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'date',
                    'label' => 'Custom Start Date',
                    'hint' => 'Used only when Date Range is set to Custom Date Range.',
                ],
            ],
            [
                'option' => 'custom_end_date',
                'value' => null,
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'date',
                    'label' => 'Custom End Date',
                    'hint' => 'Used only when Date Range is set to Custom Date Range.',
                ],
            ],
            [
                'option' => 'rank_by',
                'value' => 'revenue',
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Ranking Method',
                    'options' => [
                        'revenue' => 'Revenue',
                        'quantity' => 'Quantity Sold',
                    ],
                    'hint' => 'Primary sort for the Selling Products list. Revenue is the default.',
                ],
            ],
            [
                'option' => 'eligible_order_statuses',
                'value' => [
                    'Complete',
                    'Submitted',
                    'Approved',
                    'Processing',
                    'Pending',
                ],
                'type' => 'json',
                'field' => [
                    'name' => 'value',
                    'type' => 'textarea',
                    'label' => 'Eligible Order Statuses',
                    'hint' => 'JSON array of order statuses included when calculating top-selling products.',
                ],
            ],
            [
                'option' => 'order_type',
                'value' => CustomerOrder::IS_ORDER_TYPE,
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Order Type',
                    'options' => [
                        CustomerOrder::IS_ORDER_TYPE => 'Order',
                        CustomerOrder::IS_RFQ_TYPE => 'RFQ (Request for Quotation)',
                    ],
                    'hint' => 'Only lines from orders of this type are included.',
                ],
            ],
        ];
    }
}

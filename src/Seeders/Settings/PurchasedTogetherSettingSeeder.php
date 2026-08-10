<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\CustomerOrder;
use Amplify\System\Backend\Models\SystemConfiguration;
use Amplify\System\Helpers\UtilityHelper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchasedTogetherSettingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::query()->where('name', 'purchased_together')->delete();

        SystemConfiguration::query()
            ->where('name', 'schedule')
            ->where('option', 'like', 'commands.purchased_together.%')
            ->delete();

        foreach ($this->purchasedTogetherSettings() as $datum) {
            $this->createSetting('purchased_together', $datum);
        }

        foreach ($this->scheduleSettings() as $datum) {
            $this->createSetting('schedule', $datum);
        }
    }

    private function createSetting(string $name, array $datum): void
    {
        $type = $datum['type'] ?? 'string';

        SystemConfiguration::create([
            'name' => $name,
            'option' => $datum['option'],
            'type' => $type,
            'value' => UtilityHelper::stringify($type, $datum['value'] ?? null),
            'field' => $datum['field'] ?? null,
            'active' => true,
        ]);
    }

    private function purchasedTogetherSettings(): array
    {
        return [
            [
                'option' => 'enabled',
                'value' => true,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Enable Frequently Purchased Together Aggregation',
                    'hint' => 'When enabled, the scheduled job aggregates co-purchase pairs from order history.',
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
                    'hint' => 'JSON array of order statuses included when calculating co-purchase pairs.',
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
                    'hint' => 'Only lines from orders of this type are included in aggregation.',
                ],
            ],
            [
                'option' => 'months_lookback',
                'value' => null,
                'type' => 'integer',
                'field' => [
                    'name' => 'value',
                    'type' => 'number',
                    'label' => 'Months Lookback',
                    'hint' => 'Leave empty for full order history, or enter number of months to limit aggregation window.',
                ],
            ],
            [
                'option' => 'use_order_chunks',
                'value' => false,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Process Orders in Queued Chunks',
                    'hint' => 'Enable for very large datasets. Dispatches parallel chunk jobs instead of a single SQL aggregation.',
                ],
            ],
            [
                'option' => 'order_chunk_size',
                'value' => 500,
                'type' => 'integer',
                'field' => [
                    'name' => 'value',
                    'type' => 'number',
                    'label' => 'Order Chunk Size',
                    'hint' => 'Number of orders processed per chunk job when chunk mode is enabled.',
                ],
            ],
            [
                'option' => 'insert_chunk_size',
                'value' => 1000,
                'type' => 'integer',
                'field' => [
                    'name' => 'value',
                    'type' => 'number',
                    'label' => 'Insert Chunk Size',
                    'hint' => 'Number of pair rows inserted per batch when storing aggregation results.',
                ],
            ],
        ];
    }

    private function scheduleSettings(): array
    {
        return [
            [
                'option' => 'commands.purchased_together.enabled',
                'value' => true,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Enable Scheduled Aggregation',
                ],
            ],
            [
                'option' => 'commands.purchased_together.interval',
                'value' => 'daily',
                'type' => 'string',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Schedule Interval',
                    'options' => [
                        'hourly' => 'Hourly',
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                    ],
                ],
            ],
            [
                'option' => 'commands.purchased_together.time.minute',
                'value' => '0',
                'type' => 'string',
            ],
            [
                'option' => 'commands.purchased_together.time.hour',
                'value' => '2',
                'type' => 'string',
            ],
            [
                'option' => 'commands.purchased_together.time.day',
                'value' => '*',
                'type' => 'string',
            ],
            [
                'option' => 'commands.purchased_together.time.month',
                'value' => '*',
                'type' => 'string',
            ],
            [
                'option' => 'commands.purchased_together.time.weekday',
                'value' => '*',
                'type' => 'string',
            ],
        ];
    }
}

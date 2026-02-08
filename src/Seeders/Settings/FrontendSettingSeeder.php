<?php

namespace Amplify\System\Backend\Seeders\Settings;

use Amplify\System\Backend\Models\SystemConfiguration;
use Illuminate\Database\Seeder;

class FrontendSettingSeeder extends Seeder
{
    use \Illuminate\Database\Console\Seeds\WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::where('name', 'frontend')->delete();

        foreach ($this->data() as $datum) {
            $datum['name'] = 'frontend';
            SystemConfiguration::create($datum);
        }
    }

    private function data()
    {
        return [
            [
                'option' => 'shop_page_default_view',
                'value' => 'list',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Shop Page Default View',
                    'options' => [
                        'list' => 'List View',
                        'grid' => 'Grid View'
                    ]
                ],
            ],
            [
                'option' => 'product_available_text',
                'value' => 'Available',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Product Available Text',
                    'hint' => 'This texts will appear if you don\'t want to show the exact quantity but explain stock available'
                ]
            ],
            [
                'option' => 'product_not_available_text',
                'value' => 'Available in 3-5 days',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Product Not Available Text',
                    'hint' => 'This texts will appear if you don\'t want to zero quantity but explain Restock possibility'
                ]
            ],
            [
                'option' => 'enable_language',
                'value' => false,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Display language switch option on site?'
                ],
            ],
            [
                'option' => 'mega_menu_max_height',
                'value' => '310px',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Mega Menu Maximum Height',
                    'hint' => 'Default Height calculation unit is pixel(px)'
                ]
            ],
            [
                'option' => 'guest_default',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Guest Customer ID',
                    'hint' => 'Guest ID that will be used to get public pricing from ERP'
                ]
            ],
            [
                'option' => 'guest_checkout_warehouse',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'select2_from_ajax',
                    'label' => 'Guest Warehouse',
                    'hint' => 'Guest Warehouse that will be used to get public pricing from ERP',
                    'data_source' => backpack_url('warehouse/fetch/warehouse-dropdown'),
                    'placeholder' => 'Select a Warehouse',
                    'key' => 'code',
                    'minimum_input_length' => 0,
                    'method' => 'POST',
                    'attribute' => 'name',
                    'model' => \Amplify\System\Backend\Models\Warehouse::class,
                    'entity' => 'guestWarehouse'
                ]
            ],
            [
                'option' => 'guest_checkout',
                'value' => false,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Enable Guest Checkout?',
                    'hint' => 'If enabled system will allow guest without login to checkout'
                ]
            ],
            [
                'option' => 'guest_add_to_cart',
                'value' => false,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Enable Guest Add To Cart?',
                    'hint' => 'If enabled system will allow guest to add item to cart without login'
                ]
            ],
            [
                'option' => 'force_shipping_address_customer_id',
                'value' => '',
                'field' => [
                    'name' => 'value',
                    'type' => 'text',
                    'label' => 'Force a Shipping Address',
                    'hint' => 'Enter comma seperated the customer codes, those upon login will force to select a shipping address'
                ]
            ],
            [
                'option' => 'cart_item_badge_style',
                'value' => 'items',
                'field' => [
                    'name' => 'value',
                    'type' => 'select_from_array',
                    'label' => 'Item count Badge Style on Cart',
                    'options' => [
                        'items' => 'Number of items',
                        'quantities' => 'Total Quantities'
                    ]
                ],
            ],
            [
                'option' => 'show_parent_product_for_sku',
                'value' => true,
                'type' => 'bool',
                'field' => [
                    'name' => 'value',
                    'type' => 'boolean',
                    'label' => 'Show Master Product Page from SKU link?',
                    'hint' => 'If enabled system will redirect to master product page from ordered SKU'
                ]
            ],
        ];
    }
}

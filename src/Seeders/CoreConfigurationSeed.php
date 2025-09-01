<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\CoreConfiguration;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoreConfigurationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function run()
    {
        CoreConfiguration::query()->create(
            [
                'navbar_brand' => 'img/Amplify Logo 280 tagline.png',
                'footer_image' => 'img/Powered by EasyAsk.png',
                'default_language' => array_keys(collect(config('backpack.crud.locales'))->toArray()),
                'product_search_by_id_prefix' => 'Products.ProductId',
                'easyask_host' => 'demoV16.easyaskondemand.com',
                'easyask_dictionary' => 'amplify-rbs',
                'front_page_id' => 12,
                'shop_page_id' => 10,
                'product_page_id' => 11,
                'order_details_page_id' => 27,
                'quotation_details_page_id' => 29,
                'order_list_items_page_id' => 24,
                'mandatory_fields' => json_encode([
                    '1', '2', '5',
                ], JSON_THROW_ON_ERROR),
                'hierarchies' => [
                    'Category', 'ProductClassification',
                ],
            ]
        );

        $mandatory_fields = [
            ['id' => '1', 'name' => 'Product Name', 'slug' => 'product_name', 'created_at' => '2021-06-25 10:36:13', 'updated_at' => '2021-06-25 10:36:13'],
            ['id' => '2', 'name' => 'Product Code', 'slug' => 'product_code', 'created_at' => '2021-06-25 10:18:24', 'updated_at' => '2021-06-25 10:18:24'],
            ['id' => '3', 'name' => 'Description', 'slug' => 'description', 'created_at' => '2021-06-25 11:08:34', 'updated_at' => '2021-06-25 11:08:34'],
            ['id' => '4', 'name' => 'Categories', 'slug' => 'categories', 'created_at' => '2021-06-25 11:08:34', 'updated_at' => '2021-06-25 11:08:34'],
            ['id' => '5', 'name' => 'Product Classification', 'slug' => 'product_classification_id', 'created_at' => '2021-06-25 11:08:34', 'updated_at' => '2021-06-25 11:08:34'],
        ];
        DB::table('mandatory_fields')->insert($mandatory_fields);
    }
}

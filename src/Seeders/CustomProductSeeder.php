<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\CustomProduct;
use Illuminate\Database\Seeder;

class CustomProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customProducts = [
            [
                'name' => 'Cutting Board',
                'type' => 'cutting-board',
                'value' => file_get_contents(public_path('frontend/rhsparts/json/custom-items/cutting-board.json')),
                'ref_link' => '/frontend/rhsparts/json/custom-items/cutting-board.json',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gasket',
                'type' => 'gasket',
                'value' => file_get_contents(public_path('frontend/rhsparts/json/custom-items/gasket.json')),
                'ref_link' => '/frontend/rhsparts/json/custom-items/gasket.json',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Replacement Strip Curtains',
                'type' => 'replacement-strip-curtains',
                'value' => file_get_contents(public_path('frontend/rhsparts/json/custom-items/replacement-strip-curtains.json')),
                'ref_link' => '/frontend/rhsparts/json/custom-items/replacement-strip-curtains.json',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Strip Curtains Bulk',
                'type' => 'strip-curtains-bulk',
                'value' => file_get_contents(public_path('frontend/rhsparts/json/custom-items/strip-curtains-bulk.json')),
                'ref_link' => '/frontend/rhsparts/json/custom-items/strip-curtains-bulk.json',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tubular Heaters',
                'type' => 'tubular-heaters',
                'value' => file_get_contents(public_path('frontend/rhsparts/json/custom-items/tubular-heater.json')),
                'ref_link' => '/frontend/rhsparts/json/custom-items/tubular-heater.json',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Drain Tube Heater',
                'type' => 'drain-tube-heater',
                'value' => json_encode(['product' => '64-295']),
                'ref_link' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Heater Wire Circuits',
                'type' => 'heater-wire-circuits',
                'value' => json_encode(['products' => ['Aluminum' => '64-250', 'Fiberglass' => '64-200']]),
                'ref_link' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        CustomProduct::insert($customProducts);
    }
}

<?php

namespace Amplify\System\Backend\Seeders;

use DB;
use Illuminate\Database\Seeder;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* `ecom_backpack`.`customer_groups` */
        $customer_groups = [
            ['id' => '1', 'group_code' => 'Group-1', 'group_name' => 'Group 1', 'group_pricing_type' => 'rules-based-pricing', 'created_at' => '2021-10-20 14:42:29', 'updated_at' => '2021-10-20 14:42:29'],
            ['id' => '2', 'group_code' => 'Group-2', 'group_name' => 'Group 2', 'group_pricing_type' => 'group-price-per-product', 'created_at' => '2021-10-20 14:44:58', 'updated_at' => '2021-10-20 14:44:58'],
            ['id' => '3', 'group_code' => 'Group-3', 'group_name' => 'Group 3', 'group_pricing_type' => 'no-pricing-shown', 'created_at' => '2021-10-20 14:46:52', 'updated_at' => '2021-10-20 14:46:52'],
            ['id' => '4', 'group_code' => 'Group-4', 'group_name' => 'Group 4', 'group_pricing_type' => 'retails-pricing-only', 'created_at' => '2021-10-20 14:47:14', 'updated_at' => '2021-10-20 14:47:14'],
        ];

        DB::table('customer_groups')->insert($customer_groups);
    }
}

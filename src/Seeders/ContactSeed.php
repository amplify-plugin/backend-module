<?php

namespace Amplify\System\Backend\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('customers')->truncate();
        DB::table('customer_addresses')->truncate();
        DB::table('contacts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        /* `ecom_backpack`.`customers` */
        $customers = [
            ['id' => '1', 'customer_code' => 'abc-company', 'customer_name' => 'ABC Company', 'email' => 'office@abccompany.com', 'phone' => '132416546464', 'punch_out' => '0', 'punch_out_configuration' => null, 'customer_type' => 'Retail', 'customer_group_id' => null, 'created_at' => '2022-06-15 15:08:07', 'updated_at' => '2022-06-15 15:08:07', 'deleted_at' => null, 'approved' => '1'],
            ['id' => '2', 'customer_code' => 'CODE-1', 'customer_name' => 'Russell Booth', 'email' => 'bigag@mailinator.com', 'phone' => '+1 (344) 921-9814', 'punch_out' => '0', 'punch_out_configuration' => null, 'customer_type' => 'Retail', 'customer_group_id' => null, 'created_at' => '2022-06-15 15:47:12', 'updated_at' => '2022-06-15 15:50:33', 'deleted_at' => null, 'approved' => '1'],
        ];
        $customer_addresses = [
            ['id' => '8', 'customer_id' => '2', 'address_name' => 'Carla French', 'address' => 'Harum veniam anim n', 'zip_code' => '53637', 'office_phone_number' => '+1 (827) 963-6775', 'office_email' => 'tigibaf@mailinator.com', 'created_at' => '2022-06-15 15:51:29', 'updated_at' => '2022-06-15 15:51:29'],
            ['id' => '9', 'customer_id' => '2', 'address_name' => 'Clare Perez', 'address' => '47 South Rocky New Freeway', 'zip_code' => '61689', 'office_phone_number' => '+1 (314) 937-2623', 'office_email' => 'mypig@mailinator.com', 'created_at' => '2022-06-15 15:51:29', 'updated_at' => '2022-06-15 15:51:29'],
            ['id' => '10', 'customer_id' => '2', 'address_name' => 'new', 'address' => 'new', 'zip_code' => 'new', 'office_phone_number' => 'new2 ', 'office_email' => 'new', 'created_at' => '2022-06-15 15:51:29', 'updated_at' => '2022-06-15 15:51:29'],
            ['id' => '11', 'customer_id' => '1', 'address_name' => 'Main Branch', 'address' => 'Home address', 'zip_code' => '1122', 'office_phone_number' => '1233456', 'office_email' => 'office@abccompany.com', 'created_at' => '2022-06-16 11:04:46', 'updated_at' => '2022-06-16 11:04:46'],
            ['id' => '12', 'customer_id' => '1', 'address_name' => 'Sub Branch', 'address' => 'Warehouse address', 'zip_code' => '2211', 'office_phone_number' => '1346546556', 'office_email' => 'office2@abccompany.com', 'created_at' => '2022-06-16 11:04:46', 'updated_at' => '2022-06-16 11:04:46'],
        ];

        /* `ecom_backpack`.`contacts` */
        $contacts = [
            ['id' => '1', 'name' => 'Admin', 'email' => 'abc@company.com', 'phone' => '13213143241', 'customer_address_id' => '11', 'customer_id' => '1', 'login_id' => 'abc@company.com', 'password' => '$2y$10$B65BAi.U9ZoG4e1hte8qr.QRk6kSpwp.svFET1EtyiY7aaw9oKgBa', 'is_admin' => '1', 'is_approver' => '0', 'order_limit' => '50000.00', 'daily_budget_limit' => '100000.00', 'monthly_budget_limit' => '300000.00', 'spend_today' => '0.00', 'spend_this_month' => '0.00', 'created_at' => '2022-06-15 15:08:07', 'updated_at' => '2022-06-21 08:10:46', 'deleted_at' => null],
            ['id' => '2', 'name' => 'Katell Bender', 'email' => 'bigag@mailinator.com', 'phone' => '+1 (485) 702-4143', 'customer_address_id' => '8', 'customer_id' => '2', 'login_id' => 'bigag@mailinator.com', 'password' => '$2y$10$TaXQhclIrMIefI6TCBJyx.SiYbe1wRw5HVyedV1HVHqKLsyd0DLHO', 'is_admin' => '1', 'is_approver' => '0', 'order_limit' => '1000.00', 'daily_budget_limit' => '2000.00', 'monthly_budget_limit' => '3000.00', 'spend_today' => '0.00', 'spend_this_month' => '0.00', 'created_at' => '2022-06-15 15:47:12', 'updated_at' => '2022-06-15 15:51:29', 'deleted_at' => null],
        ];

        DB::table('customers')->insert($customers);
        DB::table('customer_addresses')->insert($customer_addresses);
        DB::table('contacts')->insert($contacts);
    }
}

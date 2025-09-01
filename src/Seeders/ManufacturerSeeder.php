<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manufacturers = [
            ['id' => '1', 'name' => 'Senco', 'code' => 'senco', 'image' => 'uploads/images/manufacturers/703b8ae377d72f9e5cc8fb5fb5656715.jpg', 'contact_name' => 'Neville Reynolds', 'contact_address' => '[{"address_name":"Excepteur quam sunt ","address":"Dolorem facere ut au","zip_code":"123123"}]', 'contact_email' => 'fuqa@mailinator.com', 'contact_phone' => '+1 (463) 326-1803', 'featured' => 0, 'created_at' => '2022-04-07 05:53:40', 'updated_at' => '2022-04-12 10:40:35'],
            ['id' => '2', 'name' => 'Makita', 'code' => 'makita', 'image' => 'uploads/images/manufacturers/cd549bc6e7e1eb27cf3e5e6fe8c0abcd.jpg', 'contact_name' => 'Gillian Flowers', 'contact_address' => '[{"address_name":"Dolorem earum quia u","address":"Fugit dolorum corru","zip_code":"123123"}]', 'contact_email' => 'nanawocig@mailinator.com', 'contact_phone' => '+1 (341) 277-7364', 'featured' => 0, 'created_at' => '2022-04-07 05:53:55', 'updated_at' => '2022-04-12 10:33:35'],
            ['id' => '3', 'name' => 'Dewalt', 'code' => 'dewalt', 'image' => 'uploads/images/manufacturers/9d7856be26d2fe9fed7744c4692f6039.jpg', 'contact_name' => 'Idona Mcleod', 'contact_address' => '[{"address_name":"Non debitis eligendi","address":"Eveniet fugit anim","zip_code":"123123"}]', 'contact_email' => 'bebyzibyn@mailinator.com', 'contact_phone' => '+1 (566) 975-6219', 'featured' => 0, 'created_at' => '2022-04-07 05:54:10', 'updated_at' => '2022-04-12 10:33:25'],
        ];
        Manufacturer::insert($manufacturers);
    }
}

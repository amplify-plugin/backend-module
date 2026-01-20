<?php

namespace Amplify\System\Backend\Seeders;

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->data() as $menuGroup) {
            \Amplify\System\Cms\Models\MenuGroup::create($menuGroup);
        }
    }

    public function data()
    {
        return [
            ['id' => 1, 'name' => 'Site Main Menu', 'short_code' => 'primary-menu', 'class' => null, 'style' => null, 'active' => 1, 'is_reserved' => 1, 'created_at' => '2022-06-09 20:48:59', 'updated_at' => '2022-06-09 20:48:59'],
            ['id' => 2, 'name' => 'Site Toolbar Menu', 'short_code' => 'account-menu', 'class' => null, 'style' => null, 'active' => 1, 'is_reserved' => 1, 'created_at' => '2022-06-10 15:29:10', 'updated_at' => '2022-06-10 15:29:10'],
            ['id' => 3, 'name' => 'Customer Portal Sidebar Menu', 'short_code' => 'account-sidebar', 'class' => null, 'style' => null, 'active' => 1, 'is_reserved' => 1, 'created_at' => '2022-06-10 15:29:10', 'updated_at' => '2022-06-10 15:29:10'],
            ['id' => 4, 'name' => 'Mobile Sidebar Menu', 'short_code' => 'mobile-menu', 'class' => null, 'style' => null, 'active' => 1, 'is_reserved' => 1, 'created_at' => '2022-07-29 16:11:17', 'updated_at' => '2022-07-29 16:11:17'],
        ];
    }
}

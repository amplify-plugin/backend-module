<?php

namespace Amplify\System\Backend\Seeders;

use Illuminate\Database\Seeder;

class PageConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PageSeeder::class);
        $this->call(WidgetSeeder::class);
        $this->call(MenuSeeder::class);
    }
}

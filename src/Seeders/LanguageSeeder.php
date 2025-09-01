<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            ['name' => 'English', 'code' => 'en', 'flag' => 'frontend/layout-1/img/flags/GB.png', 'created_at' => '2022-06-29 09:02:44', 'updated_at' => '2022-06-30 01:07:14'],
            ['name' => 'Français', 'code' => 'fr', 'flag' => 'frontend/layout-1/img/flags/FR.png', 'created_at' => '2022-06-30 01:11:35', 'updated_at' => '2022-06-30 01:11:35'],
            ['name' => 'Deutsch', 'code' => 'de', 'flag' => 'frontend/layout-1/img/flags/DE.png', 'created_at' => '2022-06-30 01:12:39', 'updated_at' => '2022-06-30 01:12:39'],
            ['name' => 'Italiano', 'code' => 'it', 'flag' => 'frontend/layout-1/img/flags/IT.png', 'created_at' => '2022-06-30 01:13:14', 'updated_at' => '2022-06-30 01:13:14'],
        ];

        Language::insert($languages);
    }
}

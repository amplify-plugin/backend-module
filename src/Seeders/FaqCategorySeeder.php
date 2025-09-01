<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\FaqCategory;
use DB;
use Illuminate\Database\Seeder;

class FaqCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        FaqCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $faq_categories = [
            ['id' => '1', 'name' => 'Basic', 'slug' => 'basic', 'created_at' => '2022-05-17 12:34:48', 'updated_at' => '2022-05-17 12:34:48'],
            ['id' => '2', 'name' => 'Service', 'slug' => 'service', 'created_at' => '2022-05-17 12:35:02', 'updated_at' => '2022-05-17 12:35:02'],
            ['id' => '3', 'name' => 'Pricing', 'slug' => 'pricing', 'created_at' => '2022-05-17 12:35:02', 'updated_at' => '2022-05-17 12:35:02'],
        ];
        FaqCategory::insert(($faq_categories));
    }
}

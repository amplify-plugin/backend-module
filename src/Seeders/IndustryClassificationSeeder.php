<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\IndustryClassification;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class IndustryClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $industryClassifications = [
            ['name' => 'RESTAURANT', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'FABRICATION', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'EDUCATION', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'HOTEL', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'WALK IN CASH', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'HOBBY', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'WATER FILTRATION', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'CONSTRUCTION', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'MILITARY', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'FARMING AND FOOD PROCESSING', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'MANUFACTURING', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'AUTOMOTIVE', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'LABORATORY', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'BREW HOUSE', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'AGRICULTURE', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'AEROSPACE', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'PARTYSUPPLY', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'MEDICAL', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'DISTRIBUTOR', 'status' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        IndustryClassification::insert($industryClassifications);
    }
}

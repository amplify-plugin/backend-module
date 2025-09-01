<?php

namespace Amplify\System\Backend\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DocumentType::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $document_types = [
            ['id' => '1', 'name' => 'Spec Sheet (Google Docs)', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'media_type' => 'google_sheet', 'created_at' => '2022-05-10 13:36:01', 'updated_at' => '2022-05-13 10:26:15'],
            ['id' => '2', 'name' => 'Installation Guide', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'media_type' => 'pdf', 'created_at' => '2022-05-10 13:40:59', 'updated_at' => '2022-05-10 13:40:59'],
            ['id' => '3', 'name' => 'Config Image', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s', 'media_type' => 'image', 'created_at' => '2022-05-10 13:41:43', 'updated_at' => '2022-05-12 14:32:50'],
            ['id' => '4', 'name' => 'Setup Video', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'media_type' => 'video', 'created_at' => '2022-05-12 07:37:16', 'updated_at' => '2022-05-12 14:30:39'],
            ['id' => '5', 'name' => 'Config Guide (Google Docs)', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'media_type' => 'google_doc', 'created_at' => '2022-05-12 07:38:04', 'updated_at' => '2022-05-13 10:26:04'],
            ['id' => '6', 'name' => 'Spec Sheet', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'media_type' => 'xls', 'created_at' => '2022-05-13 10:26:44', 'updated_at' => '2022-05-13 10:26:44'],
            ['id' => '7', 'name' => 'Config Guide', 'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.', 'media_type' => 'doc', 'created_at' => '2022-05-13 10:27:09', 'updated_at' => '2022-05-13 10:27:09'],
        ];
        DocumentType::insert($document_types);
    }
}

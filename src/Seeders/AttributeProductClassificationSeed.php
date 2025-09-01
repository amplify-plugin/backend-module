<?php

namespace Amplify\System\Backend\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AttributeProductClassificationSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = [
            ['id' => '1', 'name' => '{"en":"Size","fr":"FR Size"}', 'description' => null, 'type' => 'integer', 'unit' => 'Inches', 'has_range' => '1', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 04:56:49', 'updated_at' => '2022-02-04 11:44:10', 'deleted_at' => null, 'slug' => 'size'],
            ['id' => '2', 'name' => '{"en":"Laptop RAM","fr":"Portable RAM","ro":"Unitate hard disk"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 04:56:49', 'updated_at' => '2022-02-04 11:43:39', 'deleted_at' => null, 'slug' => 'laptop-ram'],
            ['id' => '3', 'name' => '{"en":"Laptop Processor","fr":"Portable processeur","it":"Processore","ro":"Procesor"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 05:06:11', 'updated_at' => '2022-02-04 11:43:01', 'deleted_at' => null, 'slug' => 'laptop-processor'],
            ['id' => '4', 'name' => '{"en":"Laptop SSD","fr":"Unitate hard disk","ro":"Unitate hard disk","it":"Disco rigido"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 05:09:56', 'updated_at' => '2022-02-04 11:42:50', 'deleted_at' => null, 'slug' => 'laptop-processor'],
            ['id' => '5', 'name' => '{"en":"SSD\\/HDD Caddy","fr":"Support de disque dur","it":"Carrello per dischi rigidi","ro":"Hard disk Caddy"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 05:15:34', 'updated_at' => '2022-02-04 11:42:39', 'deleted_at' => null, 'slug' => 'ssd-caddy'],
            ['id' => '6', 'name' => '{"en":"Laptop Charger","fr":"Chargeur d\'ordinateur portable","ro":"\\u00cenc\\u0103rc\\u0103tor pentru laptop","it":"Caricabatterie per laptop"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 05:15:34', 'updated_at' => '2022-02-04 11:42:29', 'deleted_at' => null, 'slug' => 'laptop-charger'],
            ['id' => '7', 'name' => '{"en":"Power Backup","fr":"Source de courant"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-24 11:32:16', 'updated_at' => '2022-02-04 11:42:14', 'deleted_at' => null, 'slug' => 'power-backup'],
            ['id' => '8', 'name' => '{"en":"Test Boolean Attributes"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 05:09:56', 'updated_at' => '2022-02-04 11:41:54', 'deleted_at' => null, 'slug' => 'test-boolean-attributes'],
            ['id' => '9', 'name' => '{"en":"Desktop SSD","fr":"Bureau SSD"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 05:09:56', 'updated_at' => '2022-02-04 11:41:41', 'deleted_at' => null, 'slug' => 'desktop-ssd'],
            ['id' => '10', 'name' => '{"en":"Palmtop SSD","fr":"Bureau Unitate hard disk"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 05:09:56', 'updated_at' => '2022-02-04 11:41:04', 'deleted_at' => null, 'slug' => 'palmtop-ssd'],
            ['id' => '11', 'name' => '{"en":"Display Monitor"}', 'description' => null, 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '0', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-24 12:26:34', 'updated_at' => '2022-02-04 11:36:29', 'deleted_at' => null, 'slug' => 'display-monitor'],
            ['id' => '12', 'name' => '{"en":"Color","fr":"Color"}', 'description' => 'Color', 'type' => 'text', 'unit' => null, 'has_range' => '0', 'use_as_filter' => '1', 'searchable' => '0', 'tunable' => '1', 'is_new' => '0', 'is_updated' => '0', 'created_at' => '2021-06-16 04:56:49', 'updated_at' => '2022-02-04 11:36:06', 'deleted_at' => null, 'slug' => 'color'],
        ];
        /* `ecom_backpack`.`attribute_product_classification` */
        $attribute_product_classification = [
            ['id' => '6', 'attribute_id' => '2', 'classification_id' => '6', 'min' => '1', 'max' => '16', 'boolean_titles' => null, 'enums' => null, 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2022-02-04 11:49:31', 'updated_at' => '2022-02-04 11:49:31'],
            ['id' => '7', 'attribute_id' => '3', 'classification_id' => '6', 'min' => null, 'max' => null, 'boolean_titles' => null, 'enums' => '["core i3","core i5","corei5","core i7"]', 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2022-02-04 11:49:31', 'updated_at' => '2022-02-04 11:49:31'],
            ['id' => '8', 'attribute_id' => '4', 'classification_id' => '6', 'min' => '120', 'max' => '480', 'boolean_titles' => null, 'enums' => null, 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2022-02-04 11:49:31', 'updated_at' => '2022-02-04 11:49:31'],
            ['id' => '13', 'attribute_id' => '9', 'classification_id' => '7', 'min' => '120', 'max' => '480', 'boolean_titles' => null, 'enums' => null, 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2022-02-04 11:50:34', 'updated_at' => '2022-02-04 11:50:34'],
            ['id' => '14', 'attribute_id' => '11', 'classification_id' => '7', 'min' => null, 'max' => null, 'boolean_titles' => null, 'enums' => '["14\\"","20\\"","24\\""]', 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2022-02-04 11:50:34', 'updated_at' => '2022-02-04 11:50:34'],
            ['id' => '15', 'attribute_id' => '7', 'classification_id' => '7', 'min' => null, 'max' => null, 'boolean_titles' => null, 'enums' => '["UPS","IPS"]', 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2022-02-04 11:50:34', 'updated_at' => '2022-02-04 11:50:34'],
            ['id' => '16', 'attribute_id' => '8', 'classification_id' => '7', 'min' => null, 'max' => null, 'boolean_titles' => '{"true":"1","false":"0"}', 'enums' => null, 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2022-02-04 11:50:34', 'updated_at' => '2022-02-04 11:50:34'],
            ['id' => '19', 'attribute_id' => '5', 'classification_id' => '9', 'min' => null, 'max' => null, 'boolean_titles' => null, 'enums' => null, 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2021-07-08 08:47:05', 'updated_at' => '2021-07-08 08:47:05'],
            ['id' => '20', 'attribute_id' => '9', 'classification_id' => '9', 'min' => '1', 'max' => '2', 'boolean_titles' => null, 'enums' => null, 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2021-07-08 08:47:05', 'updated_at' => '2021-07-08 08:47:05'],
            ['id' => '21', 'attribute_id' => '11', 'classification_id' => '9', 'min' => null, 'max' => null, 'boolean_titles' => null, 'enums' => '["a","b","c"]', 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2021-07-08 08:47:05', 'updated_at' => '2021-07-08 08:47:05'],
            ['id' => '22', 'attribute_id' => '8', 'classification_id' => '9', 'min' => null, 'max' => null, 'boolean_titles' => '{"true":"yes","false":"no"}', 'enums' => null, 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2021-07-08 08:47:05', 'updated_at' => '2021-07-08 08:47:05'],
            ['id' => '23', 'attribute_id' => '2', 'classification_id' => '10', 'min' => '10', 'max' => '100', 'boolean_titles' => null, 'enums' => null, 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2021-07-08 08:47:57', 'updated_at' => '2021-07-08 08:47:57'],
            ['id' => '24', 'attribute_id' => '4', 'classification_id' => '10', 'min' => '299', 'max' => '390', 'boolean_titles' => null, 'enums' => null, 'is_required' => '1', 'is_multiple' => '0', 'created_at' => '2021-07-08 08:47:57', 'updated_at' => '2021-07-08 08:47:57'],
            ['id' => '30', 'attribute_id' => '12', 'classification_id' => '6', 'min' => null, 'max' => null, 'boolean_titles' => null, 'enums' => '["red","black"]', 'is_required' => '1', 'is_multiple' => '1', 'created_at' => '2022-02-04 11:49:31', 'updated_at' => '2022-02-04 11:49:31'], ];

        $option_product_classification = [
            ['id' => '1', 'option_id' => '1', 'classification_id' => '6', 'created_at' => '2021-06-16 05:18:09', 'updated_at' => '2021-06-16 05:18:09'],
            ['id' => '2', 'option_id' => '2', 'classification_id' => '6', 'created_at' => '2021-06-16 05:18:09', 'updated_at' => '2021-06-16 05:18:09'],
            ['id' => '3', 'option_id' => '1', 'classification_id' => '7', 'created_at' => '2021-06-16 05:18:09', 'updated_at' => '2021-06-16 05:18:09'],
            ['id' => '4', 'option_id' => '2', 'classification_id' => '9', 'created_at' => '2021-06-16 05:18:09', 'updated_at' => '2021-06-16 05:18:09'],
            ['id' => '5', 'option_id' => '3', 'classification_id' => '9', 'created_at' => '2021-06-16 05:18:09', 'updated_at' => '2021-06-16 05:18:09'],
            ['id' => '6', 'option_id' => '1', 'classification_id' => '10', 'created_at' => '2021-06-16 05:18:09', 'updated_at' => '2021-06-16 05:18:09'],
            ['id' => '7', 'option_id' => '3', 'classification_id' => '10', 'created_at' => '2021-06-16 05:18:09', 'updated_at' => '2021-06-16 05:18:09'],
        ];

        $product_classifications = [
            ['id' => '6', 'title' => '{"en":"Laptop","it":"Il computer portatile","fr":"Portable"}', 'slug' => '{"it":"il-computer-portatile","en":"laptop","fr":"portable"}', 'parent_id' => null, 'level' => null, 'depth' => '1', 'lft' => '2', 'rgt' => '5', 'created_at' => '2021-06-16 05:18:09', 'updated_at' => '2021-07-08 09:33:44', 'deleted_at' => null],
            ['id' => '7', 'title' => '{"en":"Desktop"}', 'slug' => null, 'parent_id' => null, 'level' => null, 'depth' => '1', 'lft' => '6', 'rgt' => '9', 'created_at' => '2021-06-24 12:29:12', 'updated_at' => '2021-07-08 09:33:44', 'deleted_at' => null],
            ['id' => '9', 'title' => '{"en":"PC Config - 1"}', 'slug' => null, 'parent_id' => '7', 'level' => null, 'depth' => '2', 'lft' => '7', 'rgt' => '8', 'created_at' => '2021-07-08 08:47:03', 'updated_at' => '2021-07-08 09:33:44', 'deleted_at' => null],
            ['id' => '10', 'title' => '{"en":"Laptop Config - 1"}', 'slug' => null, 'parent_id' => '6', 'level' => null, 'depth' => '2', 'lft' => '3', 'rgt' => '4', 'created_at' => '2021-07-08 08:47:57', 'updated_at' => '2021-07-08 09:33:44', 'deleted_at' => null],
        ];

        DB::table('attributes')->insert($attributes);
        DB::table('product_classifications')->insert($product_classifications);
        DB::table('attribute_product_classification')->insert($attribute_product_classification);
        DB::table('option_product_classification')->insert($option_product_classification);
    }
}

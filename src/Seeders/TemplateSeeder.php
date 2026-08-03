<?php

namespace Amplify\System\Backend\Seeders;

use Amplify\System\Cms\Models\Theme;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data() as $template) {

            if (isset($template['label'])) {
                $template['name'] = $template['label'];
            }

            $template['component_folder'] = $template['slug'];
            $template['asset_folder'] = $template['slug'];

            Theme::create($template);
        }
    }

    public function data()
    {
        return array_map(function ($template) {
            return json_decode(file_get_contents($template), true);
        }, glob(base_path('themes/*/config.json')));
    }
}

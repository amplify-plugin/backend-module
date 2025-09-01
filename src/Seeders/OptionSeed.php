<?php

namespace Amplify\System\Backend\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
            [
                'option_name' => '{"en":"RAM Size"}',
                'is_required' => 1,
                'description' => 'Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese.',
                'option_type' => 'text',
                'limit_min' => 3,
                'limit_max' => 20,
                'value_type' => null,
                'default_value' => '8 GB',
            ],
            [
                'option_name' => '{"en":"Length"}',
                'is_required' => 0,
                'description' => 'Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese.',
                'option_type' => 'number',
                'limit_min' => 3,
                'limit_max' => 200,
                'value_type' => null,
                'default_value' => 36,
            ],
            [
                'option_name' => '{"en":"Mouse"}',
                'is_required' => 1,
                'description' => 'Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese Dolorum aliquam dese.',
                'option_type' => 'boolean',
                'limit_min' => null,
                'limit_max' => null,
                'value_type' => 'Yes/No',
                'default_value' => 'Yes',
            ],
        ]);
    }
}

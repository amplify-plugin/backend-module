<?php

namespace Amplify\System\Backend\Factories;

use Amplify\System\Backend\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->lexify('CMP-????'),
            'name' => $this->faker->company,
            'order_source_flag' => $this->faker->lexify('OSF-?'),
        ];
    }
}

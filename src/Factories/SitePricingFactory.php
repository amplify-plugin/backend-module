<?php

namespace Amplify\System\Backend\src\factories;

use App\Models\SitePricing;
use Illuminate\Database\Eloquent\Factories\Factory;

class SitePricingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SitePricing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'currency' => $this->faker->randomElement(['BDT', 'USD', 'AMD']),
        ];
    }
}

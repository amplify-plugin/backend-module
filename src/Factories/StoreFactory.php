<?php

namespace Amplify\System\Backend\Factories;

use App\Models\Store;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $warehouses = Warehouse::pluck('id')->toArray();

        return [
            'warehouse_id' => $this->faker->randomElement($warehouses),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->streetAddress(),
            'telephone' => $this->faker->phoneNumber(),
            'zip_code' => $this->faker->postcode(),
        ];
    }
}

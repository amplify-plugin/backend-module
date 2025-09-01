<?php

namespace Amplify\System\Backend\src\factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_code' => $this->faker->uuid,
            'customer_name' => $this->faker->company,
            'email' => $this->faker->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'punch_out' => $this->faker->boolean,
            // 'address'       => [
            //     [
            //         "address_name"        => $this->faker->country,
            //         "address"             => $this->faker->city,
            //         "office_phone_number" => $this->faker->phoneNumber,
            //         "office_email"        => $this->faker->email,
            //     ],
            //     [
            //         "address_name"        => $this->faker->country,
            //         "address"             => $this->faker->city,
            //         "office_phone_number" => $this->faker->phoneNumber,
            //         "office_email"        => $this->faker->email,
            //     ],
            //     [
            //         "address_name"        => $this->faker->country,
            //         "address"             => $this->faker->city,
            //         "office_phone_number" => $this->faker->phoneNumber,
            //         "office_email"        => $this->faker->email,
            //     ]
            // ],
            'customer_type' => $this->faker->randomElement(['Retail', 'Non Retail']),
            'customer_group_id' => rand(1, 4),
        ];
    }
}

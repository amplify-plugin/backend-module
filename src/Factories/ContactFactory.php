<?php

namespace Amplify\System\Backend\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $email = $this->faker->email;

        return [
            'name' => $this->faker->name,

            'email' => $email,
            'phone' => $this->faker->phoneNumber,

            // 'address' => '[{"address_name":"Lorem ","address":"Ipsum ","office_phone_number":"+88018888888","office_email":"info@office.com"}]',

            'login_id' => $email,
            'password' => Hash::make('12345678'),

            // 'limit_type' => $this->faker->randomElement(['Per Day', 'Per Month']),

            'order_limit' => $this->faker->randomFloat(3, 2),
            'daily_budget_limit' => $this->faker->randomFloat(3, 2),
            'monthly_budget_limit' => $this->faker->randomFloat(3, 2),
            'spend_today' => $this->faker->randomFloat(3, 2),
            'spend_this_month' => $this->faker->randomFloat(3, 2),
        ];
    }
}

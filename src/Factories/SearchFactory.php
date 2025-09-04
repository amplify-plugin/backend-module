<?php

namespace Amplify\System\Backend\Factories;

use App\Models\Search;
use Illuminate\Database\Eloquent\Factories\Factory;

class SearchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Search::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'dictionary_name' => $this->faker->name,
            'protocol' => $this->faker->randomElement(['HTTP', 'HTTPS']),
            'easyask_url' => $this->faker->url,
            'port' => $this->faker->randomElement(['8000', '9000', '8080', '']),
        ];
    }
}

<?php

namespace Amplify\System\Backend\Factories;

use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Site::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'site_name' => $this->faker->company,
            'site_description' => $this->faker->paragraph,
            'url' => $this->faker->url,
        ];
    }
}

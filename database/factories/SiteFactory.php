<?php

namespace Database\Factories;

use App\Models\Site;
use Illuminate\Support\Str;
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
            'code' => $this->faker->text(255),
            'name' => $this->faker->name,
            'address_1' => $this->faker->address,
            'address_2' => $this->faker->text(255),
            'city' => $this->faker->city,
            'country' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'email' => $this->faker->email,
            'display_on_orders' => $this->faker->boolean,
        ];
    }
}

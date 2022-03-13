<?php

namespace Database\Factories;

use App\Models\Sellable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SellableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sellable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(15),
            'price' => $this->faker->randomNumber(2),
            'cost' => $this->faker->randomNumber(2),
            'total_sale' => $this->faker->randomNumber(2),            
            'active' => $this->faker->boolean,
        ];
    }
}

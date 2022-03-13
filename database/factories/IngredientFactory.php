<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Ingredient;
use Illuminate\Database\Eloquent\Factories\Factory;

class IngredientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ingredient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sellable_id' => \App\Models\Sellable::factory(),
            'product_id' => \App\Models\Product::factory(),
            'measure' => $this->faker->randomNumber(2),
            'cost_price' => $this->faker->randomNumber(2),            
        ];
    }
}

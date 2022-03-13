<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\HistoricalPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoricalPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HistoricalPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'original_price' => $this->faker->randomNumber(2),
            'new_price' => $this->faker->randomNumber(2),
            'changed_by_name' => $this->faker->text(255),
            'changed_by' => $this->faker->randomNumber,
            'product_id' => \App\Models\Product::factory(),
        ];
    }
}

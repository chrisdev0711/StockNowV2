<?php

namespace Database\Factories;

use App\Models\PackType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PackType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(8),
            'unit_name' => $this->faker->text(255),
            'units_per_pack' => $this->faker->randomNumber(2),
            'serving_name' => $this->faker->text(255),
            'typical_unit_serving' => $this->faker->randomNumber(2),
        ];
    }
}

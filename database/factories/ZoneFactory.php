<?php

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Zone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(15),
            'site_id' => \App\Models\Site::factory(),
        ];
    }
}

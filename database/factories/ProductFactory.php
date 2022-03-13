<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'sku' => $this->faker->text(255),
            'description' => $this->faker->sentence(15),
            'par_level' => $this->faker->randomNumber(2),
            'reorder_point' => $this->faker->randomNumber(2),
            'supplier_sku' => $this->faker->numerify('sku######'),
            'entered_cost' => $this->faker->randomNumber(2),
            'entered_inc_vat' => $this->faker->boolean,
            'vat_rate' => $this->faker->randomNumber(2),
            'gross_cost' => $this->faker->randomNumber(2),
            'net_cost' => $this->faker->randomNumber(2),
            'pack_type' => $this->faker->text(255),
            'multipack' => $this->faker->boolean,
            'units_per_pack' => $this->faker->randomNumber(2),
            'servings_per_unit' => $this->faker->randomNumber(2),
            'product_category_id' => \App\Models\ProductCategory::factory(),
            'supplier_id' => \App\Models\Supplier::factory(),
        ];
    }
}

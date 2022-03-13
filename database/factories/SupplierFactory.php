<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company' => $this->faker->company,
            'address_1' => $this->faker->streetAddress,
            'address_2' => $this->faker->text(255),
            'city' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'payment_terms' => $this->faker->numerify('## Days'),
            'order_phone' => $this->faker->phoneNumber,
            'order_email_1' => $this->faker->email,
            'order_email_2' => $this->faker->email,
            'order_email_3' => $this->faker->email,
            'account_manager' => $this->faker->name,
            'account_manager_phone' => $this->faker->phoneNumber,
            'account_manager_email' => $this->faker->email,
        ];
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;

use App\Models\Supplier;
use App\Models\ProductCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_products_list()
    {
        $products = Product::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.products.index'));

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product()
    {
        $data = Product::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.products.store'), $data);

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_product()
    {
        $product = Product::factory()->create();

        $productCategory = ProductCategory::factory()->create();
        $supplier = Supplier::factory()->create();

        $data = [
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
            'product_category_id' => $productCategory->id,
            'supplier_id' => $supplier->id,
        ];

        $response = $this->putJson(
            route('api.products.update', $product),
            $data
        );

        $data['id'] = $product->id;

        $this->assertDatabaseHas('products', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('api.products.destroy', $product));

        $this->assertDeleted($product);

        $response->assertNoContent();
    }
}

<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Product;

use App\Models\Supplier;
use App\Models\ProductCategory;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_products()
    {
        $products = Product::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('products.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.products.index')
            ->assertViewHas('products');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_product()
    {
        $response = $this->get(route('products.create'));

        $response->assertOk()->assertViewIs('app.products.create');
    }

    /**
     * @test
     */
    public function it_stores_the_product()
    {
        $data = Product::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('products.store'), $data);

        $this->assertDatabaseHas('products', $data);

        $product = Product::latest('id')->first();

        $response->assertRedirect(route('products.edit', $product));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_product()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response
            ->assertOk()
            ->assertViewIs('app.products.show')
            ->assertViewHas('product');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_product()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.edit', $product));

        $response
            ->assertOk()
            ->assertViewIs('app.products.edit')
            ->assertViewHas('product');
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

        $response = $this->put(route('products.update', $product), $data);

        $data['id'] = $product->id;

        $this->assertDatabaseHas('products', $data);

        $response->assertRedirect(route('products.edit', $product));
    }

    /**
     * @test
     */
    public function it_deletes_the_product()
    {
        $product = Product::factory()->create();

        $response = $this->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));

        $this->assertDeleted($product);
    }
}

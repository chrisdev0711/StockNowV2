<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCategoryProductsTest extends TestCase
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
    public function it_gets_product_category_products()
    {
        $productCategory = ProductCategory::factory()->create();
        $products = Product::factory()
            ->count(2)
            ->create([
                'product_category_id' => $productCategory->id,
            ]);

        $response = $this->getJson(
            route('api.product-categories.products.index', $productCategory)
        );

        $response->assertOk()->assertSee($products[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_category_products()
    {
        $productCategory = ProductCategory::factory()->create();
        $data = Product::factory()
            ->make([
                'product_category_id' => $productCategory->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.product-categories.products.store', $productCategory),
            $data
        );

        $this->assertDatabaseHas('products', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $product = Product::latest('id')->first();

        $this->assertEquals(
            $productCategory->id,
            $product->product_category_id
        );
    }
}

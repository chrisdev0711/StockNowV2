<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Sellable;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellableProductsTest extends TestCase
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
    public function it_gets_sellable_products()
    {
        $sellable = Sellable::factory()->create();
        $product = Product::factory()->create();

        $sellable->products()->attach($product);

        $response = $this->getJson(
            route('api.sellables.products.index', $sellable)
        );

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_sellable()
    {
        $sellable = Sellable::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.sellables.products.store', [$sellable, $product])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $sellable
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_sellable()
    {
        $sellable = Sellable::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.sellables.products.store', [$sellable, $product])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $sellable
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}

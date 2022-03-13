<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\Sellable;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductSellablesTest extends TestCase
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
    public function it_gets_product_sellables()
    {
        $product = Product::factory()->create();
        $sellable = Sellable::factory()->create();

        $product->sellables()->attach($sellable);

        $response = $this->getJson(
            route('api.products.sellables.index', $product)
        );

        $response->assertOk()->assertSee($sellable->name);
    }

    /**
     * @test
     */
    public function it_can_attach_sellables_to_product()
    {
        $product = Product::factory()->create();
        $sellable = Sellable::factory()->create();

        $response = $this->postJson(
            route('api.products.sellables.store', [$product, $sellable])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->sellables()
                ->where('sellables.id', $sellable->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_sellables_from_product()
    {
        $product = Product::factory()->create();
        $sellable = Sellable::factory()->create();

        $response = $this->deleteJson(
            route('api.products.sellables.store', [$product, $sellable])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->sellables()
                ->where('sellables.id', $sellable->id)
                ->exists()
        );
    }
}

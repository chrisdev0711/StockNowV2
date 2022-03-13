<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Product;
use App\Models\HistoricalPrice;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductHistoricalPricesTest extends TestCase
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
    public function it_gets_product_historical_prices()
    {
        $product = Product::factory()->create();
        $historicalPrices = HistoricalPrice::factory()
            ->count(2)
            ->create([
                'product_id' => $product->id,
            ]);

        $response = $this->getJson(
            route('api.products.historical-prices.index', $product)
        );

        $response->assertOk()->assertSee($historicalPrices[0]->changed_by_name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_historical_prices()
    {
        $product = Product::factory()->create();
        $data = HistoricalPrice::factory()
            ->make([
                'product_id' => $product->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.products.historical-prices.store', $product),
            $data
        );

        unset($data['product_id']);

        $this->assertDatabaseHas('historical_prices', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $historicalPrice = HistoricalPrice::latest('id')->first();

        $this->assertEquals($product->id, $historicalPrice->product_id);
    }
}

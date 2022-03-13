<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Site;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteProductsTest extends TestCase
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
    public function it_gets_site_products()
    {
        $site = Site::factory()->create();
        $product = Product::factory()->create();

        $site->products()->attach($product);

        $response = $this->getJson(route('api.sites.products.index', $site));

        $response->assertOk()->assertSee($product->name);
    }

    /**
     * @test
     */
    public function it_can_attach_products_to_site()
    {
        $site = Site::factory()->create();
        $product = Product::factory()->create();

        $response = $this->postJson(
            route('api.sites.products.store', [$site, $product])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $site
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_products_from_site()
    {
        $site = Site::factory()->create();
        $product = Product::factory()->create();

        $response = $this->deleteJson(
            route('api.sites.products.store', [$site, $product])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $site
                ->products()
                ->where('products.id', $product->id)
                ->exists()
        );
    }
}

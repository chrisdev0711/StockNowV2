<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Site;
use App\Models\Product;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductSitesTest extends TestCase
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
    public function it_gets_product_sites()
    {
        $product = Product::factory()->create();
        $site = Site::factory()->create();

        $product->sites()->attach($site);

        $response = $this->getJson(route('api.products.sites.index', $product));

        $response->assertOk()->assertSee($site->name);
    }

    /**
     * @test
     */
    public function it_can_attach_sites_to_product()
    {
        $product = Product::factory()->create();
        $site = Site::factory()->create();

        $response = $this->postJson(
            route('api.products.sites.store', [$product, $site])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $product
                ->sites()
                ->where('sites.id', $site->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_sites_from_product()
    {
        $product = Product::factory()->create();
        $site = Site::factory()->create();

        $response = $this->deleteJson(
            route('api.products.sites.store', [$product, $site])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $product
                ->sites()
                ->where('sites.id', $site->id)
                ->exists()
        );
    }
}

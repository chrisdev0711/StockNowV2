<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ProductCategory;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductCategoryTest extends TestCase
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
    public function it_gets_product_categories_list()
    {
        $productCategories = ProductCategory::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.product-categories.index'));

        $response->assertOk()->assertSee($productCategories[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_product_category()
    {
        $data = ProductCategory::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.product-categories.store'),
            $data
        );

        $this->assertDatabaseHas('product_categories', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_product_category()
    {
        $productCategory = ProductCategory::factory()->create();

        $data = [
            'name' => $this->faker->words(2, true),
            'reported' => $this->faker->boolean,
        ];

        $response = $this->putJson(
            route('api.product-categories.update', $productCategory),
            $data
        );

        $data['id'] = $productCategory->id;

        $this->assertDatabaseHas('product_categories', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_product_category()
    {
        $productCategory = ProductCategory::factory()->create();

        $response = $this->deleteJson(
            route('api.product-categories.destroy', $productCategory)
        );

        $this->assertDeleted($productCategory);

        $response->assertNoContent();
    }
}

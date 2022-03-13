<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Sellable;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellableTest extends TestCase
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
    public function it_gets_sellables_list()
    {
        $sellables = Sellable::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sellables.index'));

        $response->assertOk()->assertSee($sellables[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_sellable()
    {
        $data = Sellable::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.sellables.store'), $data);

        $this->assertDatabaseHas('sellables', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_sellable()
    {
        $sellable = Sellable::factory()->create();

        $data = [
            'name' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(15),
            'active' => $this->faker->boolean,
        ];

        $response = $this->putJson(
            route('api.sellables.update', $sellable),
            $data
        );

        $data['id'] = $sellable->id;

        $this->assertDatabaseHas('sellables', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sellable()
    {
        $sellable = Sellable::factory()->create();

        $response = $this->deleteJson(
            route('api.sellables.destroy', $sellable)
        );

        $this->assertDeleted($sellable);

        $response->assertNoContent();
    }
}

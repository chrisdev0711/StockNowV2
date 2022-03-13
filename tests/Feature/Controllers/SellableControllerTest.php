<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Sellable;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SellableControllerTest extends TestCase
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
    public function it_displays_index_view_with_sellables()
    {
        $sellables = Sellable::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sellables.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sellables.index')
            ->assertViewHas('sellables');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_sellable()
    {
        $response = $this->get(route('sellables.create'));

        $response->assertOk()->assertViewIs('app.sellables.create');
    }

    /**
     * @test
     */
    public function it_stores_the_sellable()
    {
        $data = Sellable::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sellables.store'), $data);

        $this->assertDatabaseHas('sellables', $data);

        $sellable = Sellable::latest('id')->first();

        $response->assertRedirect(route('sellables.edit', $sellable));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_sellable()
    {
        $sellable = Sellable::factory()->create();

        $response = $this->get(route('sellables.show', $sellable));

        $response
            ->assertOk()
            ->assertViewIs('app.sellables.show')
            ->assertViewHas('sellable');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_sellable()
    {
        $sellable = Sellable::factory()->create();

        $response = $this->get(route('sellables.edit', $sellable));

        $response
            ->assertOk()
            ->assertViewIs('app.sellables.edit')
            ->assertViewHas('sellable');
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

        $response = $this->put(route('sellables.update', $sellable), $data);

        $data['id'] = $sellable->id;

        $this->assertDatabaseHas('sellables', $data);

        $response->assertRedirect(route('sellables.edit', $sellable));
    }

    /**
     * @test
     */
    public function it_deletes_the_sellable()
    {
        $sellable = Sellable::factory()->create();

        $response = $this->delete(route('sellables.destroy', $sellable));

        $response->assertRedirect(route('sellables.index'));

        $this->assertDeleted($sellable);
    }
}

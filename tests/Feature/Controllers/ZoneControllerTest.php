<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Zone;

use App\Models\Site;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ZoneControllerTest extends TestCase
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
    public function it_displays_index_view_with_zones()
    {
        $zones = Zone::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('zones.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.zones.index')
            ->assertViewHas('zones');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_zone()
    {
        $response = $this->get(route('zones.create'));

        $response->assertOk()->assertViewIs('app.zones.create');
    }

    /**
     * @test
     */
    public function it_stores_the_zone()
    {
        $data = Zone::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('zones.store'), $data);

        $this->assertDatabaseHas('zones', $data);

        $zone = Zone::latest('id')->first();

        $response->assertRedirect(route('zones.edit', $zone));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_zone()
    {
        $zone = Zone::factory()->create();

        $response = $this->get(route('zones.show', $zone));

        $response
            ->assertOk()
            ->assertViewIs('app.zones.show')
            ->assertViewHas('zone');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_zone()
    {
        $zone = Zone::factory()->create();

        $response = $this->get(route('zones.edit', $zone));

        $response
            ->assertOk()
            ->assertViewIs('app.zones.edit')
            ->assertViewHas('zone');
    }

    /**
     * @test
     */
    public function it_updates_the_zone()
    {
        $zone = Zone::factory()->create();

        $site = Site::factory()->create();

        $data = [
            'name' => $this->faker->words(3),
            'site_id' => $site->id,
        ];

        $response = $this->put(route('zones.update', $zone), $data);

        $data['id'] = $zone->id;

        $this->assertDatabaseHas('zones', $data);

        $response->assertRedirect(route('zones.edit', $zone));
    }

    /**
     * @test
     */
    public function it_deletes_the_zone()
    {
        $zone = Zone::factory()->create();

        $response = $this->delete(route('zones.destroy', $zone));

        $response->assertRedirect(route('zones.index'));

        $this->assertDeleted($zone);
    }
}

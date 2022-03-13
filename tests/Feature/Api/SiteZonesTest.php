<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Site;
use App\Models\Zone;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteZonesTest extends TestCase
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
    public function it_gets_site_zones()
    {
        $site = Site::factory()->create();
        $zones = Zone::factory()
            ->count(2)
            ->create([
                'site_id' => $site->id,
            ]);

        $response = $this->getJson(route('api.sites.zones.index', $site));

        $response->assertOk()->assertSee($zones[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_site_zones()
    {
        $site = Site::factory()->create();
        $data = Zone::factory()
            ->make([
                'site_id' => $site->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sites.zones.store', $site),
            $data
        );

        $this->assertDatabaseHas('zones', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $zone = Zone::latest('id')->first();

        $this->assertEquals($site->id, $zone->site_id);
    }
}

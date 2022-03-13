<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Site;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteTest extends TestCase
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
    public function it_gets_sites_list()
    {
        $sites = Site::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sites.index'));

        $response->assertOk()->assertSee($sites[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_site()
    {
        $data = Site::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.sites.store'), $data);

        $this->assertDatabaseHas('sites', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_site()
    {
        $site = Site::factory()->create();

        $data = [
            'code' => $this->faker->text(255),
            'name' => $this->faker->name,
            'address_1' => $this->faker->address,
            'address_2' => $this->faker->text(255),
            'city' => $this->faker->city,
            'county' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'email' => $this->faker->email,
            'display_on_orders' => $this->faker->boolean,
        ];

        $response = $this->putJson(route('api.sites.update', $site), $data);

        $data['id'] = $site->id;

        $this->assertDatabaseHas('sites', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_site()
    {
        $site = Site::factory()->create();

        $response = $this->deleteJson(route('api.sites.destroy', $site));

        $this->assertDeleted($site);

        $response->assertNoContent();
    }
}

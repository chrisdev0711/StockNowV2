<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Site;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SiteControllerTest extends TestCase
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
    public function it_displays_index_view_with_sites()
    {
        $sites = Site::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sites.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sites.index')
            ->assertViewHas('sites');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_site()
    {
        $response = $this->get(route('sites.create'));

        $response->assertOk()->assertViewIs('app.sites.create');
    }

    /**
     * @test
     */
    public function it_stores_the_site()
    {
        $data = Site::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sites.store'), $data);

        $this->assertDatabaseHas('sites', $data);

        $site = Site::latest('id')->first();

        $response->assertRedirect(route('sites.edit', $site));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_site()
    {
        $site = Site::factory()->create();

        $response = $this->get(route('sites.show', $site));

        $response
            ->assertOk()
            ->assertViewIs('app.sites.show')
            ->assertViewHas('site');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_site()
    {
        $site = Site::factory()->create();

        $response = $this->get(route('sites.edit', $site));

        $response
            ->assertOk()
            ->assertViewIs('app.sites.edit')
            ->assertViewHas('site');
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

        $response = $this->put(route('sites.update', $site), $data);

        $data['id'] = $site->id;

        $this->assertDatabaseHas('sites', $data);

        $response->assertRedirect(route('sites.edit', $site));
    }

    /**
     * @test
     */
    public function it_deletes_the_site()
    {
        $site = Site::factory()->create();

        $response = $this->delete(route('sites.destroy', $site));

        $response->assertRedirect(route('sites.index'));

        $this->assertDeleted($site);
    }
}

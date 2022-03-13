<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Supplier;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SupplierTest extends TestCase
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
    public function it_gets_suppliers_list()
    {
        $suppliers = Supplier::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.suppliers.index'));

        $response->assertOk()->assertSee($suppliers[0]->company);
    }

    /**
     * @test
     */
    public function it_stores_the_supplier()
    {
        $data = Supplier::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.suppliers.store'), $data);

        $this->assertDatabaseHas('suppliers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_supplier()
    {
        $supplier = Supplier::factory()->create();

        $data = [
            'company' => $this->faker->company,
            'address_1' => $this->faker->streetAddress,
            'address_2' => $this->faker->text(255),
            'city' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'payment_terms' => $this->faker->numerify('## Days'),
            'order_phone' => $this->faker->phoneNumber,
            'order_email_1' => $this->faker->email,
            'order_email_2' => $this->faker->email,
            'order_email_3' => $this->faker->email,
            'account_manager' => $this->faker->name,
            'account_manager_phone' => $this->faker->phoneNumber,
            'account_manager_email' => $this->faker->email,
        ];

        $response = $this->putJson(
            route('api.suppliers.update', $supplier),
            $data
        );

        $data['id'] = $supplier->id;

        $this->assertDatabaseHas('suppliers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_supplier()
    {
        $supplier = Supplier::factory()->create();

        $response = $this->deleteJson(
            route('api.suppliers.destroy', $supplier)
        );

        $this->assertDeleted($supplier);

        $response->assertNoContent();
    }
}

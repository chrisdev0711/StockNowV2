<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $name = env('USER_NAME');
      $email = env('USER_EMAIL');
      $password = env('USER_PASSWORD');
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => "{$name}",
                'email' => "{$email}",
                'password' => \Hash::make("{$password}"),
            ]);
        $this->call(PermissionsSeeder::class);
        $this->call(StockTakesPermissionSeeder::class);

        // $this->call(UserSeeder::class);
        // $this->call(SiteSeeder::class);
        // $this->call(SupplierSeeder::class);
        // $this->call(ProductCategorySeeder::class);
        // $this->call(PackTypeSeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(HistoricalPriceSeeder::class);
        // $this->call(ZoneSeeder::class);
        // $this->call(SellableSeeder::class);
        // $this->call(IngredientSeeder::class);
    }
}

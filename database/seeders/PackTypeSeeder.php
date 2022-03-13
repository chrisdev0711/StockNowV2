<?php

namespace Database\Seeders;

use App\Models\PackType;
use Illuminate\Database\Seeder;

class PackTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PackType::factory()
            ->count(5)
            ->create();
    }
}

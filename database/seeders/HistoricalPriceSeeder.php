<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HistoricalPrice;

class HistoricalPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HistoricalPrice::factory()
            ->count(5)
            ->create();
    }
}

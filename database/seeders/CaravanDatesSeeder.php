<?php

namespace Database\Seeders;

use App\Models\CaravanDates;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CaravanDatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        CaravanDates::truncate();
        CaravanDates::factory()
            ->count(1000)
            ->create()
        ;
    }
}

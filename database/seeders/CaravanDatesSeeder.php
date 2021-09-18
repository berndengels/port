<?php

namespace Database\Seeders;

use App\Models\CaravanDates;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CaravanDatesSeeder extends Seeder
{
    private $count = 1500;
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
            ->count($this->count)
            ->create()
        ;
    }
}

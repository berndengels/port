<?php
namespace Database\Seeders;

use App\Models\BoatDates;
use Database\Seeders\Ext\MainTestSeeder;

class BoatDatesSeeder extends MainTestSeeder
{
    protected $table = 'boat_dates';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoatDates::factory()
            ->count(100)
            ->create();
    }
}

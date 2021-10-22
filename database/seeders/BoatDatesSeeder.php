<?php
namespace Database\Seeders;

use App\Models\BoatDates;
use Database\Seeders\Ext\MainSeeder;

class BoatDatesSeeder extends MainSeeder
{
    protected $count = 500;
    protected $table = 'boat_dates';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoatDates::factory()
            ->count($this->count)
            ->create();
    }
}

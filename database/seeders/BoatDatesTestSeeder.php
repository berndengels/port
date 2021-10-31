<?php
namespace Database\Seeders;

use App\Models\BoatDates;
use Database\Seeders\Ext\MainTestSeeder;

class BoatDatesTestSeeder extends MainTestSeeder
{
    protected $count = 50;
    protected $table = 'boat_dates';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoatDates::factory()
            ->connection('test')
            ->count($this->count)
            ->create();
    }
}

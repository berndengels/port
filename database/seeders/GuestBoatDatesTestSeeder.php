<?php
namespace Database\Seeders;

use App\Models\GuestBoat;
use App\Models\GuestBoatDates;
use Database\Seeders\Ext\MainTestSeeder;

class GuestBoatDatesTestSeeder extends MainTestSeeder
{
    protected $count = 50;
    protected $table = 'boat_guest_dates';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GuestBoatDates::factory()
            ->count($this->count)
            ->create()
        ;
    }
}

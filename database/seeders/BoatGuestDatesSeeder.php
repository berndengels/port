<?php
namespace Database\Seeders;

use App\Models\BoatGuest;
use App\Models\BoatGuestDates;
use Database\Seeders\Ext\MainSeeder;

class BoatGuestDatesSeeder extends MainSeeder
{
    protected $count = 500;
    protected $table = 'boat_guest_dates';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoatGuestDates::factory()
            ->count(500)
            ->create()
        ;
    }
}

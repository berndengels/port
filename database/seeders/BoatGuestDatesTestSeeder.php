<?php
namespace Database\Seeders;

use App\Models\BoatGuest;
use App\Models\BoatGuestDates;
use Database\Seeders\Ext\MainTestSeeder;

class BoatGuestDatesTestSeeder extends MainTestSeeder
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
        BoatGuestDates::factory()
            ->count($this->count)
            ->create()
        ;
    }
}

<?php
namespace Database\Seeders;

use App\Models\BoatGuest;
use App\Models\BoatGuestDates;
use Database\Seeders\Ext\MainTestSeeder;

class BoatGuestTestSeeder extends MainTestSeeder
{
    protected $table = 'boat_guests';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BoatGuest::factory()
            ->hasDates(3)
            ->count($this->count)
            ->create()
        ;
    }
}

<?php
namespace Database\Seeders;

use App\Models\GuestBoatDates;
use Database\Seeders\Ext\MainTestSeeder;

class GuestBoatDatesSeeder extends MainTestSeeder
{
    protected $count = 500;
    protected $table = 'guest_boat_dates';
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

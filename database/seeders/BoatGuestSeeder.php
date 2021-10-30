<?php
namespace Database\Seeders;

use App\Models\BoatGuest;
use Database\Seeders\Ext\MainSeeder;

class BoatGuestSeeder extends MainSeeder
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
            ->count($this->count)
            ->create()
        ;
    }
}

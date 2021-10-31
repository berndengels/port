<?php
namespace Database\Seeders;

use App\Models\BoatGuest;
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
            ->connection('test')
            ->count($this->count)
            ->create()
        ;
    }
}

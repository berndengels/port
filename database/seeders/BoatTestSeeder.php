<?php
namespace Database\Seeders;

use App\Models\Boat;
use App\Models\ServiceRequest;
use Database\Seeders\Ext\MainTestSeeder;

class BoatTestSeeder extends MainTestSeeder
{
    protected $table = 'boats';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Boat::factory()
            ->hasServiceRequests(2)
            ->count(30)
            ->create();
    }
}

<?php
namespace Database\Seeders;

use App\Models\Boat;
use App\Models\Caravan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class BoatSeeder extends Seeder
{
    private $count = 500;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Boat::truncate();
        Boat::factory()
            ->count($this->count)
            ->create();
    }
}

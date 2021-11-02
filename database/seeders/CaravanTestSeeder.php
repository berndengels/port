<?php
namespace Database\Seeders;

use App\Models\Caravan;
use App\Models\CaravanDates;
use App\Models\Country;
use Database\Seeders\Ext\MainTestSeeder;
use Illuminate\Support\Facades\Schema;

class CaravanTestSeeder extends MainTestSeeder
{
    protected $table = 'caravans';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Caravan::factory()
            ->hasDates(3)
            ->count($this->count)
            ->create();
    }
}

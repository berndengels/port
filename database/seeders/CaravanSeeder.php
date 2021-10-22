<?php
namespace Database\Seeders;

use App\Models\Caravan;
use Database\Seeders\Ext\MainSeeder;
use Illuminate\Support\Facades\Schema;

class CaravanSeeder extends MainSeeder
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
            ->count($this->count)
            ->create();
    }
}

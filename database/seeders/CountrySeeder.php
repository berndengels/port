<?php

namespace Database\Seeders;

use App\Models\Country;
use Database\Data\CountryData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        foreach(CountryData::$data as $item) {
            Country::create($item);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\ConfigBoatPrice;
use Database\Data\ConfigBoatPriceData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigBoatPriceTestSeeder extends MainTestSeeder
{
    protected $table = 'config_boat_prices';
    protected $model = ConfigBoatPrice::class;
    protected $dataClass = ConfigBoatPriceData::class;
}

<?php

namespace Database\Seeders;

use Database\Data\ConfigBoatPriceData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigBoatPriceSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_boat_prices';
    protected $dataClass = ConfigBoatPriceData::class;
}

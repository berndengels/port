<?php

namespace Database\Seeders;

use Database\Data\ConfigHasPriceComponentData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigHasPriceComponentTestSeeder extends MainTestSeeder
{
    protected $table = 'config_has_price_components';
    protected $dataClass = ConfigHasPriceComponentData::class;
}

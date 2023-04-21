<?php

namespace Database\Seeders;

use Database\Data\ConfigPriceComponentData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigPriceComponentSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_price_components';
    protected $dataClass = ConfigPriceComponentData::class;
}

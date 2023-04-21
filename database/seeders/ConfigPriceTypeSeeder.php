<?php

namespace Database\Seeders;

use Database\Data\ConfigPriceTypeData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigPriceTypeSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_price_types';
    protected $dataClass = ConfigPriceTypeData::class;
}

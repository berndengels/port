<?php

namespace Database\Seeders;

use App\Models\ConfigPriceType;
use Database\Data\ConfigPriceTypeData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigPriceTypeTestSeeder extends MainTestSeeder
{
    protected $table = 'config_price_types';
    protected $model = ConfigPriceType::class;
    protected $dataClass = ConfigPriceTypeData::class;
}

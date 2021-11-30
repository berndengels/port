<?php

namespace Database\Seeders;

use App\Models\ConfigPriceType;
use Database\Data\PriceTypeData;
use Database\Seeders\Ext\MainTestSeeder;

class PriceTypeTestSeeder extends MainTestSeeder
{
    protected $table = 'price_types';
    protected $model = ConfigPriceType::class;
    protected $dataClass = PriceTypeData::class;
}

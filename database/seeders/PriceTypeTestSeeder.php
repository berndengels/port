<?php

namespace Database\Seeders;

use App\Models\PriceType;
use Database\Data\PriceTypeData;
use Database\Seeders\Ext\MainTestSeeder;

class PriceTypeTestSeeder extends MainTestSeeder
{
    protected $table = 'price_types';
    protected $model = PriceType::class;
    protected $dataClass = PriceTypeData::class;
}

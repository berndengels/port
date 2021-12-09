<?php

namespace Database\Seeders;

use App\Models\ConfigPriceComponent;
use Database\Data\ConfigPriceComponentData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigPriceComponentTestSeeder extends MainTestSeeder
{
    protected $table = 'config_price_components';
    protected $model = ConfigPriceComponent::class;
    protected $dataClass = ConfigPriceComponentData::class;
}

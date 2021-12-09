<?php

namespace Database\Seeders;

use App\Models\ConfigDailyPrice;
use Database\Data\ConfigDailyPriceData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigDailyPriceTestSeeder extends MainTestSeeder
{
    protected $table = 'config_daily_prices';
    protected $model = ConfigDailyPrice::class;
    protected $dataClass = ConfigDailyPriceData::class;
}

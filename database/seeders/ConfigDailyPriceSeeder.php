<?php

namespace Database\Seeders;

use Database\Data\ConfigDailyPriceData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigDailyPriceSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_daily_prices';
    protected $dataClass = ConfigDailyPriceData::class;
}

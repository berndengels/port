<?php

namespace Database\Seeders;

use Database\Data\ConfigOfferData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigOfferSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'config_offers';
    protected $dataClass = ConfigOfferData::class;
}

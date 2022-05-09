<?php

namespace Database\Seeders;

use App\Models\ConfigOffer;
use Database\Data\ConfigOfferData;
use Database\Seeders\Ext\MainTestSeeder;

class ConfigOfferTestSeeder extends MainTestSeeder
{
    protected $table = 'config_offers';
    protected $model = ConfigOffer::class;
    protected $dataClass = ConfigOfferData::class;
}

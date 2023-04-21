<?php
namespace Database\Seeders;

use Database\Data\CaravanDateData;
use Database\Seeders\Ext\MainTestSeeder;

class CaravanDatesSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'caravan_dates';
    protected $dataClass = CaravanDateData::class;
}

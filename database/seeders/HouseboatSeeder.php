<?php

namespace Database\Seeders;

use Database\Data\HouseboatData;
use Database\Seeders\Ext\MainTestSeeder;

class HouseboatSeeder extends MainTestSeeder
{
    protected $table = 'houseboats';
    protected $dataClass = HouseboatData::class;
}

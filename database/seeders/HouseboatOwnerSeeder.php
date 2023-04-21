<?php

namespace Database\Seeders;

use Database\Data\HouseboatOwnerData;
use Database\Seeders\Ext\MainTestSeeder;

class HouseboatOwnerSeeder extends MainTestSeeder
{
    protected $table = 'houseboat_owners';
    protected $dataClass = HouseboatOwnerData::class;
}

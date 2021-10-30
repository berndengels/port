<?php
namespace Database\Seeders;

use Database\Data\CountryData;
use Database\Seeders\Ext\MainSeeder;

class CountrySeeder extends MainSeeder
{
    protected $table = 'countries';
    protected $dataClass = CountryData::class;
}

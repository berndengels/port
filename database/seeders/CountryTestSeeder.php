<?php
namespace Database\Seeders;

use Database\Data\CountryData;
use Database\Seeders\Ext\MainTestSeeder;

class CountryTestSeeder extends MainTestSeeder
{
    protected $table = 'countries';
    protected $dataClass = CountryData::class;
}

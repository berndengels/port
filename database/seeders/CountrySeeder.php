<?php
namespace Database\Seeders;

use Database\Data\CountryData;
use Database\Seeders\Ext\MainTestSeeder;

class CountrySeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'countries';
    protected $dataClass = CountryData::class;
}

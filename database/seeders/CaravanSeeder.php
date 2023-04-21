<?php
namespace Database\Seeders;

use Database\Data\CaravanData;
use Database\Seeders\Ext\MainTestSeeder;

class CaravanSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'caravans';
    protected $dataClass = CaravanData::class;
}

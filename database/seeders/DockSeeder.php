<?php

namespace Database\Seeders;

use Database\Data\DockData;
use Database\Seeders\Ext\MainTestSeeder;

class DockSeeder extends MainTestSeeder
{
    protected $table = 'docks';
    protected $dataClass = DockData::class;
}

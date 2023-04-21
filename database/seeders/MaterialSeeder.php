<?php

namespace Database\Seeders;

use Database\Data\MaterialData;
use Database\Seeders\Ext\MainTestSeeder;

class MaterialSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'materials';
    protected $dataClass = MaterialData::class;
}

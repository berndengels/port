<?php

namespace Database\Seeders;

use Database\Data\BerthCategoryData;
use Database\Seeders\Ext\MainTestSeeder;

class BerthCategorySeeder extends MainTestSeeder
{
    protected $table = 'berth_categories';
    protected $dataClass = BerthCategoryData::class;
}

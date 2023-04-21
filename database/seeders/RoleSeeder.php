<?php

namespace Database\Seeders;

use Database\Data\RoleData;
use Database\Seeders\Ext\MainTestSeeder;

class RoleSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'roles';
    protected $dataClass = RoleData::class;
}

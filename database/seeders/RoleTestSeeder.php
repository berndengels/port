<?php

namespace Database\Seeders;

use App\Models\Role;
use Database\Data\RoleData;
use Database\Seeders\Ext\MainTestSeeder;

class RoleTestSeeder extends MainTestSeeder
{
    protected $table = 'roles';
    protected $model = Role::class;
    protected $dataClass = RoleData::class;
}

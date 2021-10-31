<?php
namespace Database\Seeders;

use Database\Data\RoleHasPermissionsData;
use Database\Seeders\Ext\MainTestSeeder;

class RoleHasPermissionsTestSeeder extends MainTestSeeder
{
    protected $table = 'role_has_permissions';
    protected $dataClass = RoleHasPermissionsData::class;
}

<?php
namespace Database\Seeders;

use Database\Data\RoleHasPermissionsData;
use Database\Seeders\Ext\MainSeeder;

class RoleHasPermissionsSeeder extends MainSeeder
{
    protected $table = 'role_has_permissions';
    protected $dataClass = RoleHasPermissionsData::class;
}

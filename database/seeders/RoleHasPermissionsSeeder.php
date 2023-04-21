<?php
namespace Database\Seeders;

use Database\Data\RoleHasPermissionData;
use Database\Seeders\Ext\MainTestSeeder;

class RoleHasPermissionsSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'role_has_permissions';
    protected $dataClass = RoleHasPermissionData::class;
}

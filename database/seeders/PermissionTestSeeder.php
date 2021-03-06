<?php
namespace Database\Seeders;

use App\Models\Permission;
use Database\Data\PermissionData;
use Database\Seeders\Ext\MainTestSeeder;

class PermissionTestSeeder extends MainTestSeeder
{
    protected $table = 'permissions';
    protected $model = Permission::class;
    protected $dataClass = PermissionData::class;
}

<?php
namespace Database\Seeders;

use App\Models\Permission;
use Database\Seeders\Ext\MainSeeder;

class PermissionSeeder extends MainSeeder
{
    protected $table = 'permissions';
    protected $model = Permission::class;
}

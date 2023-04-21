<?php
namespace Database\Seeders;

use Database\Data\PermissionData;
use Database\Seeders\Ext\MainTestSeeder;

class PermissionSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'permissions';
    protected $dataClass = PermissionData::class;
}

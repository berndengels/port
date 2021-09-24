<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as BasePermissions;

class Permissions extends BasePermissions
{
    use HasFactory;

    protected $table = 'permissions';
}

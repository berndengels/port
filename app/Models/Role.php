<?php

namespace App\Models;

use Spatie\Permission\Models\Role as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends BaseModel
{
    use HasFactory;

    protected $appends = ['rolesString'];

    public function getRolesStringAttribute() {
        return $this->roles->map->name->join(', ');
    }
}

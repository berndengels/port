<?php

namespace App\Models;

use Eloquent;
use App\Libs\AppCache;
use Illuminate\Support\Carbon;
use Database\Factories\AdminRoleFactory;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $roles_string
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|Customer[] $users
 * @property-read int|null $users_count
 * @method static Builder|Role newModelQuery()
 * @method static Builder|Role newQuery()
 * @method static Builder|Role permission($permissions)
 * @method static Builder|Role query()
 * @method static Builder|Role whereCreatedAt($value)
 * @method static Builder|Role whereGuardName($value)
 * @method static Builder|Role whereId($value)
 * @method static Builder|Role whereName($value)
 * @method static Builder|Role whereUpdatedAt($value)
 * @mixin Eloquent
 * @property-read mixed $str_roles
 * @method static AdminRoleFactory factory(...$parameters)
 */
class Role extends BaseModel
{
    use HasFactory, ClearCache;

    protected $appends = ['strRoles'];
    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_ADMIN_ROLE,
        AppCache::KEY_OPTIONS_CUSTOMER_ROLE,
        AppCache::KEY_OPTIONS_WEB_ROLE,
        AppCache::KEY_OPTIONS_DATA_ADMIN_ROLE,
        AppCache::KEY_OPTIONS_DATA_CUSTOMER_ROLE,
        AppCache::KEY_OPTIONS_DATA_WEB_ROLE,
    ];

    public function getStrRolesAttribute()
    {
        if($this->roles && $this->roles->count() > 0) {
            return $this->roles->map->name->join(', ');
        }
        return null;
    }
}

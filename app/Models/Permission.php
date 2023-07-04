<?php
namespace App\Models;

use Eloquent;
use App\Libs\AppCache;
use Database\Factories\PermissionFactory;
use Illuminate\Support\Carbon;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission as BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $uniq_name
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, \App\Models\Customer> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\PermissionFactory factory($count = null, $state = [])
 * @method static Builder|Permission filter(?string $name = null, $value = null)
 * @method static Builder|Permission filterDateFrom(?string $name = null, $value = null)
 * @method static Builder|Permission filterDateUntil(?string $name = null, $value = null)
 * @method static Builder|Permission filterMonth(?string $name = null, $value = null)
 * @method static Builder|Permission filterYear(?string $name = null, $value = null)
 * @method static Builder|Permission likeFilter(?string $name = null, $value = null)
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission permission($permissions)
 * @method static Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission role($roles, $guard = null)
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereGuardName($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Permission extends BaseModel
{
    use HasFactory, Filter, ClearCache;

    protected $guarded = ['id'];
    protected $appends = ['actions', 'uniqName'];

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_PERMISSION,
        AppCache::KEY_OPTIONS_DATA_PERMISSION,
    ];

    public static function actions()
    {
        return [
            'read'  => 'read',
            'write' => 'write'
        ];
    }

    public function getUniqNameAttribute()
    {
        return $this->name . ' ' . $this->guard_name;
    }
}

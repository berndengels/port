<?php
namespace App\Models;

use Eloquent;
use App\Traits\Models\Filter\Filter;
use App\Traits\Models\ClearsResponseCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
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
 * @property-read mixed $action
 * @property-read mixed $actions
 * @property-read mixed $model
 * @property-read mixed $uniq_name
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @property-read Collection|Customer[] $users
 * @property-read int|null $users_count
 * @method static Builder|Permission newModelQuery()
 * @method static Builder|Permission newQuery()
 * @method static Builder|Permission permission($permissions)
 * @method static Builder|Permission query()
 * @method static Builder|Permission role($roles, $guard = null)
 * @method static Builder|Permission whereCreatedAt($value)
 * @method static Builder|Permission whereGuardName($value)
 * @method static Builder|Permission whereId($value)
 * @method static Builder|Permission whereName($value)
 * @method static Builder|Permission whereUpdatedAt($value)
 * @mixin Eloquent
 * @method static Builder|Permission filter(?string $name = null)
 */
class Permission extends BaseModel
{
    use HasFactory, Filter, ClearsResponseCache;
    protected $appends = ['actions','model','action','uniqName'];
    public $action;
    public $model;

    protected static $actions = [
        'read'  => 'read',
        'write' => 'write'
    ];

    public static function actions()
    {
        return self::$actions;
    }

    public function getUniqNameAttribute()
    {
        return $this->name . ' '  .$this->guard_name;
    }

    public static function getActionsAttribute()
    {
        return self::actions();
    }

    public function getModelAttribute()
    {
        return $this->model;
    }

    public function getActionAttribute()
    {
        return $this->action;
    }
}

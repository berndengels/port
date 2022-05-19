<?php
namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\UseBooleanIcon;
use Database\Factories\CustomerFactory;
use Database\Factories\RandomCustomerFactory;
use Eloquent;
use App\Traits\Models\ClearCache;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $customer_type
 * @property string $name
 * @property string|null $email
 * @property string|null $password
 * @property string|null $remember_token
 * @property string|null $fon
 * @property string|null $state
 * @property string|null $street
 * @property string|null $postcode
 * @property string|null $city
 * @property-read Collection|Boat[] $boats
 * @property-read int|null $boats_count
 * @property-read mixed $fon_link
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection|Role[] $roles
 * @property-read int|null $roles_count
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer permission($permissions)
 * @method static Builder|Customer query()
 * @method static Builder|Customer role($roles, $guard = null)
 * @method static Builder|Customer whereCity($value)
 * @method static Builder|Customer whereCustomerType($value)
 * @method static Builder|Customer whereEmail($value)
 * @method static Builder|Customer whereFon($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer wherePassword($value)
 * @method static Builder|Customer wherePostcode($value)
 * @method static Builder|Customer whereRememberToken($value)
 * @method static Builder|Customer whereState($value)
 * @method static Builder|Customer whereStreet($value)
 * @mixin Eloquent
 * @property int|null $confirmed
 * @method static Builder|Customer whereConfirmed($value)
 * @method static CustomerFactory factory(...$parameters)
 * @property-read mixed $str_roles
 * @property-read Collection|HouseboatDates[] $houseboatDates
 * @property-read int|null $houseboat_dates_count
 */
class Customer extends Authenticatable
{
    use CanResetPassword;
    use ClearCache;
    use Dispatchable;
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use ThrottlesLogins;
    use UseBooleanIcon;

    protected $table = 'customers';
    protected $guard_name = 'customer';
    protected $appends = ['fonLink','strRoles'];
    protected $guarded = ['id'];
    protected $hidden = ['password','remember_token'];
    protected $casts = [
        'confirmed' => 'boolean',
    ];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_CUSTOMER,
        AppCache::KEY_OPTIONS_DATA_CUSTOMER,
    ];

    public function boats()
    {
        return $this->hasMany(Boat::class);
    }

    public function houseboatDates()
    {
        return $this->hasMany(HouseboatDates::class);
    }

    public function getFonLinkAttribute()
    {
        if($this->fon && !str_starts_with($this->fon, '+49')) {
            $sanitized = preg_replace('/^0|[ \t]+/i', '', $this->fon);
            if(!str_starts_with($this->fon, '49')) {
                return '49' . $sanitized;
            }
            return $sanitized;
        }
        return null;
    }

    public function getStrRolesAttribute()
    {
        return $this->roles->map->name->join(', ');
    }

    public static function randomFactory()
    {
        return RandomCustomerFactory::new();
    }
}

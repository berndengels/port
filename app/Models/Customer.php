<?php

namespace App\Models;

use Eloquent;
use App\Traits\Models\ClearsResponseCache;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
 */
class Customer extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable, CanResetPassword, ThrottlesLogins, Dispatchable, ClearsResponseCache;

    protected $table = 'customers';
    protected $appends = ['fonLink'];
    protected $guarded = ['id'];
    protected $hidden = ['password','remember_token'];
    public $timestamps = false;

    public function getFonLinkAttribute()
    {
        if($this->fon) {
            return '+49' . preg_replace('/^0|[ \t]+/i','', $this->fon);
        }
        return null;
    }

    public function boats()
    {
        return $this->hasMany(Boat::class);
    }

}

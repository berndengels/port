<?php
namespace App\Models;

use App\Notifications\CraneDateRequest;
use Database\Factories\AdminUserFactory;
use Eloquent;
use App\Traits\Models\ClearCache;
use Database\Factories\CustomerFactory;
use App\Notifications\AdminResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $fon
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property string|null $profile_photo_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $str_roles
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static AdminUserFactory factory($count = null, $state = [])
 * @method static Builder|AdminUser newModelQuery()
 * @method static Builder|AdminUser newQuery()
 * @method static Builder|AdminUser permission($permissions)
 * @method static Builder|AdminUser query()
 * @method static Builder|AdminUser role($roles, $guard = null)
 * @method static Builder|AdminUser whereCreatedAt($value)
 * @method static Builder|AdminUser whereEmail($value)
 * @method static Builder|AdminUser whereEmailVerifiedAt($value)
 * @method static Builder|AdminUser whereFon($value)
 * @method static Builder|AdminUser whereId($value)
 * @method static Builder|AdminUser whereName($value)
 * @method static Builder|AdminUser wherePassword($value)
 * @method static Builder|AdminUser whereProfilePhotoPath($value)
 * @method static Builder|AdminUser whereRememberToken($value)
 * @method static Builder|AdminUser whereTwoFactorRecoveryCodes($value)
 * @method static Builder|AdminUser whereTwoFactorSecret($value)
 * @method static Builder|AdminUser whereUpdatedAt($value)
 * @mixin Eloquent
 */
class AdminUser extends Authenticatable
{
    use HasFactory,
        HasRoles,
        Notifiable,
        CanResetPassword,
        ThrottlesLogins,
        Dispatchable,
        ClearCache,
        HasApiTokens;

    protected $table = 'admin_users';
    protected $guard_name = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'email', 'fon', 'password'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['strRoles'];

    public function getStrRolesAttribute()
    {
        return $this->roles->map->name->join(', ');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    /**
     * Route notifications for the Vonage channel.
     *
     * @param  Notification  $notification
     * @return string
     */
	public function routeNotificationForVonage(CraneDateRequest $notification): string
	{
		return env('MASTER_FON');
	}
}

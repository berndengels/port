<?php

namespace App\Models;

use Eloquent;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Team $currentTeam
 * @property-read string $profile_photo_url
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|Team[] $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read Collection|Team[] $teams
 * @property-read int|null $teams_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|AdminUser newModelQuery()
 * @method static Builder|AdminUser newQuery()
 * @method static Builder|AdminUser query()
 * @method static Builder|AdminUser whereCreatedAt($value)
 * @method static Builder|AdminUser whereEmail($value)
 * @method static Builder|AdminUser whereEmailVerifiedAt($value)
 * @method static Builder|AdminUser whereId($value)
 * @method static Builder|AdminUser whereName($value)
 * @method static Builder|AdminUser wherePassword($value)
 * @method static Builder|AdminUser whereRememberToken($value)
 * @method static Builder|AdminUser whereTwoFactorRecoveryCodes($value)
 * @method static Builder|AdminUser whereTwoFactorSecret($value)
 * @method static Builder|AdminUser whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @method static Builder|AdminUser whereCurrentTeamId($value)
 * @method static Builder|AdminUser whereProfilePhotoPath($value)
 */
class AdminUser extends Authenticatable
{
    use HasRoles;
//    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
//    use TwoFactorAuthenticatable;

    protected $table = 'admin_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

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
    protected $appends = [
        'profile_photo_url',
    ];
}

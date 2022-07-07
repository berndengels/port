<?php

namespace App\Models;

use App\Traits\Models\UseBooleanIcon;
use Database\Factories\GuestBoatBerthFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\GuestBoatBerth
 *
 * @property int $id
 * @property string $number
 * @property string|null $width
 * @property string|null $length
 * @property string|null $daily_price
 * @property float|null $lat
 * @property float|null $lng
 * @property int $enabled
 * @property-read Collection|GuestBoatDates[] $guestBoatDates
 * @property-read int|null $guest_boat_dates_count
 * @method static GuestBoatBerthFactory factory(...$parameters)
 * @method static Builder|GuestBoatBerth newModelQuery()
 * @method static Builder|GuestBoatBerth newQuery()
 * @method static Builder|GuestBoatBerth query()
 * @method static Builder|GuestBoatBerth whereDailyPrice($value)
 * @method static Builder|GuestBoatBerth whereEnabled($value)
 * @method static Builder|GuestBoatBerth whereId($value)
 * @method static Builder|GuestBoatBerth whereLat($value)
 * @method static Builder|GuestBoatBerth whereLength($value)
 * @method static Builder|GuestBoatBerth whereLng($value)
 * @method static Builder|GuestBoatBerth whereNumber($value)
 * @method static Builder|GuestBoatBerth whereWidth($value)
 * @mixin Eloquent
 * @property int|null $boat_dock_id
 * @property-read BoatDock|null $dock
 * @method static Builder|GuestBoatBerth whereBoatDockId($value)
 */
class GuestBoatBerth extends Model
{
    use HasFactory;
    use UseBooleanIcon;

    protected $table = 'guest_boat_berths';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'enabled'       => 'boolean',
        'width'         => 'float',
        'length'        => 'float',
        'daily_price'   => 'float',
    ];

    public function guestBoatDates()
    {
        return $this->hasMany(GuestBoatDates::class);
    }

    public function dock()
    {
        return $this->belongsTo(BoatDock::class, 'boat_dock_id', 'id');
    }
}

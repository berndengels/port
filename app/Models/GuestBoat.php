<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\Filter\GuestBoatFilter;
use App\Traits\Models\HasDailyPrice;
use Database\Factories\GuestBoatFactory;
use Eloquent;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\boatGuest
 *
 * @method static Builder|GuestBoat newModelQuery()
 * @method static Builder|GuestBoat newQuery()
 * @method static Builder|GuestBoat query()
 * @mixin Eloquent
 * @property int $id
 * @property string $name
 * @property string $length
 * @property string $home_port
 * @property-read Collection|GuestBoatDates[] $dates
 * @property-read int|null $dates_count
 * @method static GuestBoatFactory factory(...$parameters)
 * @method static Builder|GuestBoat filter(?string $name = null)
 * @method static Builder|GuestBoat whereHomePort($value)
 * @method static Builder|GuestBoat whereId($value)
 * @method static Builder|GuestBoat whereLength($value)
 * @method static Builder|GuestBoat whereName($value)
 * @method static Builder|GuestBoat guestBoat(?int $id = null)
 * @method static Builder|GuestBoat guestBoatByDates(?int $id = null)
 */
class GuestBoat extends BaseModel
{
    use HasFactory, ClearCache, GuestBoatFilter, Filter;

    protected $table = 'guest_boats';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_GUEST_BOAT,
        AppCache::KEY_OPTIONS_DATA_GUEST_BOAT,
    ];

    public function dates()
    {
        return $this->hasMany(GuestBoatDates::class, 'guest_boat_id', 'id');
    }
}

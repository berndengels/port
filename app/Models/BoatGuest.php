<?php

namespace App\Models;

use App\Libs\AppCache;
use Database\Factories\BoatGuestFactory;
use Eloquent;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\boatGuest
 *
 * @method        static Builder|boatGuest newModelQuery()
 * @method        static Builder|boatGuest newQuery()
 * @method        static Builder|boatGuest query()
 * @mixin         Eloquent
 * @property      int $id
 * @property      string $name
 * @property      string $length
 * @property      string $home_port
 * @property-read Collection|BoatGuestDates[] $dates
 * @property-read int|null $dates_count
 * @method        static BoatGuestFactory factory(...$parameters)
 * @method        static Builder|BoatGuest filter(?string $name = null)
 * @method        static Builder|BoatGuest whereHomePort($value)
 * @method        static Builder|BoatGuest whereId($value)
 * @method        static Builder|BoatGuest whereLength($value)
 * @method        static Builder|BoatGuest whereName($value)
 */
class BoatGuest extends BaseModel
{
    use HasFactory, ClearCache, Filter;

    protected $table = 'boat_guests';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_BOAT_GUEST,
        AppCache::KEY_OPTIONS_DATA_BOAT_GUEST,
    ];

    public function dates()
    {
        return $this->hasMany(BoatGuestDates::class, 'boat_guest_id', 'id');
    }
}

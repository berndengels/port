<?php

namespace App\Models;

use Eloquent;
use App\Libs\AppCache;
use App\Traits\Models\IsPriceable;
use App\Traits\Models\Filter\GuestBoatFilter;
use Database\Factories\GuestBoatFactory;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\boatGuest
 *
 * @property int $id
 * @property string $name
 * @property string $home_port
 * @property string|null $email
 * @property string $length
 * @property int|null $weight
 * @property string|null $draft
 * @property string|null $type
 * @property-read Collection<int, \App\Models\CraneDate> $craneDates
 * @property-read int|null $crane_dates_count
 * @property-read Collection<int, \App\Models\GuestBoatDates> $dates
 * @property-read int|null $dates_count
 * @method static \Database\Factories\GuestBoatFactory factory($count = null, $state = [])
 * @method static Builder|GuestBoat filter(?string $name = null, $value = null)
 * @method static Builder|GuestBoat filterDateFrom(?string $name = null, $value = null)
 * @method static Builder|GuestBoat filterDateUntil(?string $name = null, $value = null)
 * @method static Builder|GuestBoat filterMonth(?string $name = null, $value = null)
 * @method static Builder|GuestBoat filterYear(?string $name = null, $value = null)
 * @method static Builder|GuestBoat guestBoat(?int $id = null)
 * @method static Builder|GuestBoat guestBoatById(?int $id = null)
 * @method static Builder|GuestBoat likeFilter(?string $name = null, $value = null)
 * @method static Builder|GuestBoat newModelQuery()
 * @method static Builder|GuestBoat newQuery()
 * @method static Builder|GuestBoat query()
 * @method static Builder|GuestBoat sortable($defaultParameters = null)
 * @method static Builder|GuestBoat whereDraft($value)
 * @method static Builder|GuestBoat whereEmail($value)
 * @method static Builder|GuestBoat whereHomePort($value)
 * @method static Builder|GuestBoat whereId($value)
 * @method static Builder|GuestBoat whereLength($value)
 * @method static Builder|GuestBoat whereName($value)
 * @method static Builder|GuestBoat whereType($value)
 * @method static Builder|GuestBoat whereWeight($value)
 * @mixin Eloquent
 */
class GuestBoat extends BaseModel
{
    use HasFactory, ClearCache, GuestBoatFilter, Filter, IsPriceable, Sortable;

    protected $table = 'guest_boats';
    protected $guarded = ['id'];
    public $timestamps = false;
    public $sortable = ['name'];

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_GUEST_BOAT,
        AppCache::KEY_OPTIONS_DATA_GUEST_BOAT,
    ];

    public function dates()
    {
        return $this->hasMany(GuestBoatDates::class, 'guest_boat_id', 'id');
    }

    public function craneDates()
    {
        return $this->morphMany(CraneDate::class, 'cranable');
    }
}

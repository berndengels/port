<?php
namespace App\Models;

use App\Contracts\Models\IDatePrice;
use App\Traits\Models\HasDailyPrice;
use Database\Factories\GuestBoatDatesFactory;
use Eloquent;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;

/**
 * App\Models\boatGuestDates
 *
 * @method static Builder|GuestBoatDates newModelQuery()
 * @method static Builder|GuestBoatDates newQuery()
 * @method static Builder|GuestBoatDates query()
 * @mixin Eloquent
 * @property int $id
 * @property int $boat_guest_id
 * @property Carbon $from
 * @property Carbon $until
 * @property int $persons
 * @property int|null $electric
 * @property int|null $day_price
 * @property int $price
 * @property string $prices
 * @property-read GuestBoat $boat
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method static GuestBoatDatesFactory factory(...$parameters)
 * @method static Builder|GuestBoatDates filter(?string $name = null)
 * @method static Builder|GuestBoatDates whereBoatGuestId($value)
 * @method static Builder|GuestBoatDates whereDayPrice($value)
 * @method static Builder|GuestBoatDates whereElectric($value)
 * @method static Builder|GuestBoatDates whereFrom($value)
 * @method static Builder|GuestBoatDates whereId($value)
 * @method static Builder|GuestBoatDates wherePersons($value)
 * @method static Builder|GuestBoatDates wherePrice($value)
 * @method static Builder|GuestBoatDates wherePrices($value)
 * @method static Builder|GuestBoatDates whereUntil($value)
 * @property int $guest_boat_id
 * @property-read int|null $prices_count
 * @method static Builder|GuestBoatDates whereGuestBoatId($value)
 */
class GuestBoatDates extends BaseModel implements IDatePrice
{
    use HasFactory, ClearCache, Filter, HasDailyPrice;

    protected $table = 'guest_boat_dates';
    protected $guarded = ['id'];
    protected $dates = ['from', 'until'];
    protected $dateFormat = 'Y-m-d';
    protected $appends = [
        'validFrom',
        'validUntil',
    ];
    public $timestamps = false;

    public function boat()
    {
        return $this->belongsTo(GuestBoat::class, 'guest_boat_id', 'id');
    }

    public function getValidFromAttribute()
    {
        return $this->from->format('Y-m-d');
    }

    public function getValidUntilAttribute()
    {
        return $this->until->format('Y-m-d');
    }

    public function getPrice(Request $request): float|int
    {
        return 0;
    }
}

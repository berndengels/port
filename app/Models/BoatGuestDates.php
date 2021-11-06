<?php
namespace App\Models;

use Database\Factories\BoatGuestDatesFactory;
use Eloquent;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * App\Models\boatGuestDates
 *
 * @method        static Builder|boatGuestDates newModelQuery()
 * @method        static Builder|boatGuestDates newQuery()
 * @method        static Builder|boatGuestDates query()
 * @mixin         Eloquent
 * @property      int $id
 * @property      int $boat_guest_id
 * @property      Carbon $from
 * @property      Carbon $until
 * @property      int $persons
 * @property      int|null $electric
 * @property      int|null $day_price
 * @property      int $price
 * @property      string $prices
 * @property-read BoatGuest $boat
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method        static BoatGuestDatesFactory factory(...$parameters)
 * @method        static Builder|BoatGuestDates filter(?string $name = null)
 * @method        static Builder|BoatGuestDates whereBoatGuestId($value)
 * @method        static Builder|BoatGuestDates whereDayPrice($value)
 * @method        static Builder|BoatGuestDates whereElectric($value)
 * @method        static Builder|BoatGuestDates whereFrom($value)
 * @method        static Builder|BoatGuestDates whereId($value)
 * @method        static Builder|BoatGuestDates wherePersons($value)
 * @method        static Builder|BoatGuestDates wherePrice($value)
 * @method        static Builder|BoatGuestDates wherePrices($value)
 * @method        static Builder|BoatGuestDates whereUntil($value)
 */
class BoatGuestDates extends BaseModel
{
    use HasFactory, ClearCache, Filter;

    protected $table = 'boat_guest_dates';
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
        return $this->belongsTo(BoatGuest::class, 'boat_guest_id', 'id');
    }

    public function getValidFromAttribute()
    {
        return $this->from->format('Y-m-d');
    }

    public function getValidUntilAttribute()
    {
        return $this->until->format('Y-m-d');
    }
}

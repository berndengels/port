<?php
namespace App\Models;

use App\Contracts\Models\IDatePrice;
use App\Traits\Models\Filter\GuestBoatFilter;
use App\Traits\Models\Filter\HasYearMonthOptions;
use App\Traits\Models\Filter\YearMonthFilter;
use App\Traits\Models\HasDailyPrice;
use App\Traits\Models\HasFromUntilDates;
use App\Traits\Models\HasPrice;
use App\Traits\Models\UseBooleanIcon;
use Database\Factories\GuestBoatDatesFactory;
use Eloquent;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\boatGuestDates
 *
 * @property int $id
 * @property int $guest_boat_id
 * @property int|null $berth_id
 * @property Carbon $from
 * @property Carbon $until
 * @property int $persons
 * @property int|null $electric
 * @property int|null $day_price
 * @property int $price
 * @property mixed $prices
 * @property bool $is_paid
 * @property-read Berth|null $berth
 * @property-read GuestBoat $boat
 * @property-read mixed $days
 * @property-read mixed $price_data
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method static Builder|GuestBoatDates dailyPrices()
 * @method static Builder|GuestBoatDates datesBetween(?\Carbon\Carbon $from = null, ?\Carbon\Carbon $until = null)
 * @method static GuestBoatDatesFactory factory($count = null, $state = [])
 * @method static Builder|GuestBoatDates filter(?string $name = null, $value = null)
 * @method static Builder|GuestBoatDates filterDateFrom(?string $name = null, $value = null)
 * @method static Builder|GuestBoatDates filterDateUntil(?string $name = null, $value = null)
 * @method static Builder|GuestBoatDates filterMonth(?string $name = null, $value = null)
 * @method static Builder|GuestBoatDates filterYear(?string $name = null, $value = null)
 * @method static Builder|GuestBoatDates fromYearMonth(?string $year = null, ?string $month = null)
 * @method static Builder|GuestBoatDates guestBoat(?int $id = null)
 * @method static Builder|GuestBoatDates guestBoatById(?int $id = null)
 * @method static Builder|GuestBoatDates likeFilter(?string $name = null, $value = null)
 * @method static Builder|GuestBoatDates newModelQuery()
 * @method static Builder|GuestBoatDates newQuery()
 * @method static Builder|GuestBoatDates query()
 * @method static Builder|GuestBoatDates sortable($defaultParameters = null)
 * @method static Builder|GuestBoatDates whereBerthId($value)
 * @method static Builder|GuestBoatDates whereDayPrice($value)
 * @method static Builder|GuestBoatDates whereElectric($value)
 * @method static Builder|GuestBoatDates whereFrom($value)
 * @method static Builder|GuestBoatDates whereGuestBoatId($value)
 * @method static Builder|GuestBoatDates whereId($value)
 * @method static Builder|GuestBoatDates whereIsPaid($value)
 * @method static Builder|GuestBoatDates wherePersons($value)
 * @method static Builder|GuestBoatDates wherePrice($value)
 * @method static Builder|GuestBoatDates wherePrices($value)
 * @method static Builder|GuestBoatDates whereUntil($value)
 * @mixin Eloquent
 */
class GuestBoatDates extends BaseModel implements IDatePrice
{
    use ClearCache,
        Filter,
        GuestBoatFilter,
        HasPrice,
        HasDailyPrice,
        HasFactory,
        HasFromUntilDates,
        HasYearMonthOptions,
        UseBooleanIcon,
        YearMonthFilter,
        Sortable;

    protected $table = 'guest_boat_dates';
    protected $guarded = ['id'];
    protected $dates = ['from', 'until'];
    protected $casts = [
        'from'      => 'date:Y-m-d',
        'until'     => 'date:Y-m-d',
        'is_paid'   => 'boolean',
    ];

//    protected $dateFormat = 'Y-m-d';
    protected $appends = [
        'days',
        'validFrom',
        'validUntil',
    ];
    public $timestamps = false;
    public $sortable = ['boat.name','from','until'];

    public function boat()
    {
        return $this->belongsTo(GuestBoat::class, 'guest_boat_id', 'id');
    }

    public function berth()
    {
        return $this->belongsTo(Berth::class, 'berth_id', 'id');
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

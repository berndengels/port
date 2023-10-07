<?php
namespace App\Models;

use Eloquent;
use App\Contracts\Models\IDatePrice;
use App\Traits\Models\Filter\BoatFilter;
use App\Traits\Models\Filter\HasYearMonthOptions;
use App\Traits\Models\Filter\YearMonthFilter;
use App\Traits\Models\HasFromUntilDates;
use App\Traits\Models\HasPrice;
use App\Traits\Models\UseBooleanIcon;
use Database\Factories\BoatDatesFactory;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Events\FireEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\BoatDates
 *
 * @property int $id
 * @property int $boat_id
 * @property string $modus
 * @property Carbon $from
 * @property Carbon $until
 * @property int $price
 * @property mixed $prices
 * @property bool $is_paid
 * @property-read Boat $boat
 * @property-read mixed $base_price
 * @property-read mixed $cleaning
 * @property-read mixed $crane
 * @property-read mixed $days
 * @property-read mixed $has_cleaning
 * @property-read mixed $has_crane
 * @property-read mixed $has_mast_crane
 * @property-read mixed $has_transport
 * @property-read mixed $mast_crane
 * @property-read mixed $period
 * @property-read mixed $price_data
 * @property-read mixed $transport
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method static Builder|BoatDates boat(?int $id = null)
 * @method static Builder|BoatDates boatById(?int $id = null)
 * @method static Builder|BoatDates datesBetween(?\Carbon\Carbon $from = null, ?\Carbon\Carbon $until = null)
 * @method static BoatDatesFactory factory($count = null, $state = [])
 * @method static Builder|BoatDates fromYearMonth(?string $year = null, ?string $month = null)
 * @method static Builder|BoatDates newModelQuery()
 * @method static Builder|BoatDates newQuery()
 * @method static Builder|BoatDates query()
 * @method static Builder|BoatDates sortable($defaultParameters = null)
 * @method static Builder|BoatDates whereBoatId($value)
 * @method static Builder|BoatDates whereFrom($value)
 * @method static Builder|BoatDates whereId($value)
 * @method static Builder|BoatDates whereIsPaid($value)
 * @method static Builder|BoatDates whereModus($value)
 * @method static Builder|BoatDates wherePrice($value)
 * @method static Builder|BoatDates wherePrices($value)
 * @method static Builder|BoatDates whereUntil($value)
 * @mixin Eloquent
 */
class BoatDates extends BaseModel implements IDatePrice
{
    use BoatFilter,
        ClearCache,
        FireEvents,
        HasFactory,
        HasPrice,
        HasFromUntilDates,
        UseBooleanIcon,
        YearMonthFilter,
        Sortable;

    protected $table = 'boat_dates';
    protected $with = 'boat';
    protected $guarded = ['id'];
    protected $dates = ['from', 'until'];
    protected $casts = [
        'from'      => 'date:Y-m-d',
        'until'     => 'date:Y-m-d',
        'is_paid'   => 'bool',
    ];
//    protected $dateFormat = 'Y-m-d';
    protected $appends = [
        'validFrom',
        'validUntil',
        'hasCrane',
        'hasMastCrane',
        'hasCleaning',
        'hasTransport',
        'priceData',
        'basePrice',
        'crane',
        'mastCrane',
        'cleaning',
        'period',
    ];
    public $timestamps = false;
    public $sortable = ['boat.name','from','until'];

    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }

    public function getHasTransportAttribute()
    {
        return (isset($this->priceData->transport) && $this->priceData->transport > 0) ? true : false;
    }

    public function getHasCraneAttribute()
    {
        return (isset($this->priceData->priceCrane) && $this->priceData->priceCrane > 0) ? true : false;
    }

    public function getHasMastCraneAttribute()
    {
        return (isset($this->priceData->priceMastCrane) && $this->priceData->priceMastCrane > 0) ? true : false;
    }

    public function getHasCleaningAttribute()
    {
        return (isset($this->priceData->priceCleaning) && $this->priceData->priceCleaning > 0) ? true : false;
    }

    public function getTransportAttribute()
    {
        return $this->priceData->priceTransport ?? null;
    }

    public function getCraneAttribute()
    {
        return $this->priceData->priceCrane ?? null;
    }

    public function getMastCraneAttribute()
    {
        return $this->priceData->priceMastCrane ?? null;
    }

    public function getCleaningAttribute()
    {
        return $this->priceData->priceCleaning ?? null;
    }

    public function getBasePriceAttribute()
    {
        return $this->priceData->priceBase ?? null;
    }

    public function getPeriodAttribute()
    {
        return $this->priceData->modusDatePeriod ?? null;
    }

    public function getPrice(Request $request): float|int
    {
        return 0;
    }
}

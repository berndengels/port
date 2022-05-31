<?php
namespace App\Models;

use App\Contracts\Models\IDatePrice;
use App\Traits\Models\Filter\BoatFilter;
use App\Traits\Models\Filter\HasYearMonthOptions;
use App\Traits\Models\Filter\YearMonthFilter;
use App\Traits\Models\HasFromUntilDates;
use App\Traits\Models\UseBooleanIcon;
use Database\Factories\BoatDatesFactory;
use Eloquent;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Events\FireEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\BoatDates
 *
 * @property int $id
 * @property int $boat_id
 * @property string $modus
 * @property Carbon $from
 * @property Carbon $until
 * @property int $price
 * @property string $prices
 * @property-read Boat $boat
 * @property-read mixed $base_price
 * @property-read mixed $cleaning
 * @property-read mixed $crane
 * @property-read mixed $days
 * @property-read mixed $has_individual_price
 * @property-read mixed $individual_price
 * @property-read mixed $is_cleaned
 * @property-read mixed $is_craned
 * @property-read mixed $is_mast_craned
 * @property-read mixed $mast_crane
 * @property-read mixed $period
 * @property-read mixed $price_data
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method static Builder|BoatDates boatByDates(?int $id = null)
 * @method static BoatDatesFactory factory(...$parameters)
 * @method static Builder|BoatDates fromYearMonth(?string $year = null, ?string $month = null)
 * @method static Builder|BoatDates getMonthsByYears($from = null, $until = null)
 * @method static Builder|BoatDates newModelQuery()
 * @method static Builder|BoatDates newQuery()
 * @method static Builder|BoatDates query()
 * @method static Builder|BoatDates whereBoatId($value)
 * @method static Builder|BoatDates whereFrom($value)
 * @method static Builder|BoatDates whereId($value)
 * @method static Builder|BoatDates whereModus($value)
 * @method static Builder|BoatDates wherePrice($value)
 * @method static Builder|BoatDates wherePrices($value)
 * @method static Builder|BoatDates whereUntil($value)
 * @mixin Eloquent
 */
class BoatDates extends BaseModel implements IDatePrice
{
    use BoatFilter;
    use ClearCache;
    use FireEvents;
    use HasFactory;
    use HasFromUntilDates;
    use HasYearMonthOptions;
    use UseBooleanIcon;
    use YearMonthFilter;

    protected $table = 'boat_dates';
    protected $with = 'boat';
    protected $guarded = ['id'];
    protected $dates = ['from', 'until'];
    protected $casts = [
        'from'  => 'date:Y-m-d',
        'until'  => 'date:Y-m-d',
    ];
//    protected $dateFormat = 'Y-m-d';
    protected $appends = [
        'validFrom',
        'validUntil',
        'isCraned',
        'isMastCraned',
        'isCleaned',
        'priceData',
        'basePrice',
        'crane',
        'mastCrane',
        'cleaning',
        'period',
    ];
    public $timestamps = false;

    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }

    public function getPriceDataAttribute()
    {
        return json_decode($this->prices);
    }

    public function getIsCranedAttribute()
    {
        return (isset($this->priceData->priceCrane) && $this->priceData->priceCrane > 0) ? true : false;
    }

    public function getIsMastCranedAttribute()
    {
        return (isset($this->priceData->priceMastCrane) && $this->priceData->priceMastCrane > 0) ? true : false;
    }

    public function getIsCleanedAttribute()
    {
        return (isset($this->priceData->priceCleaning) && $this->priceData->priceCleaning > 0) ? true : false;
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

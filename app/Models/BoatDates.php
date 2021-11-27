<?php
namespace App\Models;

use App\Contracts\Models\IDatePrice;
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
 * @method static Builder|BoatDates newModelQuery()
 * @method static Builder|BoatDates newQuery()
 * @method static Builder|BoatDates query()
 * @mixin Eloquent
 * @property int $id
 * @property int $boat_id
 * @property string $modus
 * @property Carbon $from
 * @property Carbon $until
 * @property int $price
 * @property string $prices
 * @property-read Boat $boat
 * @property-read mixed $is_cleaned
 * @property-read mixed $is_craned
 * @property-read mixed $is_mast_craned
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method static Builder|BoatDates whereBoatId($value)
 * @method static Builder|BoatDates whereFrom($value)
 * @method static Builder|BoatDates whereId($value)
 * @method static Builder|BoatDates whereModus($value)
 * @method static Builder|BoatDates wherePrice($value)
 * @method static Builder|BoatDates wherePrices($value)
 * @method static Builder|BoatDates whereUntil($value)
 * @property-read mixed $base_price
 * @property-read mixed $cleaning
 * @property-read mixed $crane
 * @property-read mixed $mast_crane
 * @property-read mixed $price_data
 * @method static BoatDatesFactory factory(...$parameters)
 * @property-read mixed $has_individual_price
 * @property-read mixed $individual_price
 * @property-read mixed $period
 */
class BoatDates extends BaseModel implements IDatePrice
{
    use HasFactory, ClearCache, FireEvents;

    protected $table = 'boat_dates';
    protected $with = 'boat';
    protected $guarded = ['id'];
    protected $dates = ['from', 'until'];
    protected $dateFormat = 'Y-m-d';
    protected $appends = [
        'validFrom',
        'validUntil',
        'isCraned',
        'isMastCraned',
        'isCleaned',
        'hasIndividualPrice',
        'priceData',
        'basePrice',
        'priceIndividual',
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

    public function getValidFromAttribute()
    {
        return $this->from->format('Y-m-d');
    }

    public function getValidUntilAttribute()
    {
        return $this->until->format('Y-m-d');
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
    public function getHasIndividualPriceAttribute()
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

    public function getIndividualPriceAttribute()
    {
        return $this->priceData->priceIndividual ?? null;
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

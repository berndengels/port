<?php

namespace App\Models;

use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\HasYearMonthOptions;
use App\Traits\Models\Filter\HouseboatFilter;
use App\Traits\Models\Filter\YearMonthFilter;
use App\Traits\Models\HasDailyPrice;
use App\Traits\Models\HasFromUntilDates;
use Carbon\Carbon;
use Database\Factories\HouseboatDatesFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HouseboatDates
 *
 * @property int $id
 * @property int $houseboat_id
 * @property Carbon $from
 * @property Carbon $until
 * @property int $price
 * @property string $prices
 * @property-read mixed $days
 * @property-read string $str_from
 * @property-read string $str_until
 * @property-read string $valid_from
 * @property-read mixed $valid_until
 * @property-read Houseboat $houseboat
 * @property-write mixed $from_day
 * @property-write mixed $until_day
 * @method static Builder|HouseboatDates dailyPrices()
 * @method static HouseboatDatesFactory factory(...$parameters)
 * @method static Builder|HouseboatDates fromYearMonth(?string $year = null, ?string $month = null)
 * @method static Builder|HouseboatDates getMonthsByYears($from = null, $until = null)
 * @method static Builder|HouseboatDates newModelQuery()
 * @method static Builder|HouseboatDates newQuery()
 * @method static Builder|HouseboatDates query()
 * @method static Builder|HouseboatDates whereFrom($value)
 * @method static Builder|HouseboatDates whereHouseboatId($value)
 * @method static Builder|HouseboatDates whereId($value)
 * @method static Builder|HouseboatDates wherePrice($value)
 * @method static Builder|HouseboatDates wherePrices($value)
 * @method static Builder|HouseboatDates whereUntil($value)
 * @mixin Eloquent
 * @property int $customer_id
 * @property-read Customer $customer
 * @method static Builder|HouseboatDates houseboatByDates(?int $id = null)
 * @method static Builder|HouseboatDates whereCustomerId($value)
 */
class HouseboatDates extends Model
{
    use ClearCache;
    use HasDailyPrice;
    use HasFactory;
    use HasFromUntilDates;
    use HasYearMonthOptions;
    use HouseboatFilter;
    use YearMonthFilter;

    protected $table = 'houseboat_dates';
    protected $guarded = ['id'];
    protected $dates = ['from','until'];
    protected $casts = [
        'from'      => 'date:Y-m-d',
        'until'     => 'date:Y-m-d',
    ];
//    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;
    protected $appends = [
        'days',
        'validFrom',
        'validUntil',
    ];

    public function houseboat()
    {
        return $this->belongsTo(Houseboat::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return string
     */
    public function getValidFromAttribute()
    {
        return $this->from->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getValidUntilAttribute()
    {
        return $this->until->format('Y-m-d');
    }
}

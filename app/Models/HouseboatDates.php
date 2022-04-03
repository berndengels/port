<?php

namespace App\Models;

use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\HasYearMonthOptions;
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
 */
class HouseboatDates extends Model
{
    use HasFactory, YearMonthFilter, HasYearMonthOptions, HasFromUntilDates, ClearCache, HasDailyPrice;

    protected $table = 'houseboat_dates';
    protected $guarded = ['id'];
    protected $dates = ['from','until'];
    protected $dateFormat = 'Y-m-d';
    public $timestamps = false;
    protected $appends = [
        'days',
//        'from',
//        'until',
        'strFrom',
        'strUntil',
        'validFrom',
        'validUntil',
    ];

    protected $casts = [
        'from'      => 'date:Y-m-d',
        'until'     => 'date:Y-m-d',
    ];

    public function houseboat()
    {
        return $this->belongsTo(Houseboat::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::created(fn(ConfigSaisonDates $model) => $model->setMdays($model)->saveQuietly());
        self::updated(fn(ConfigSaisonDates $model) => $model->setMdays($model)->saveQuietly());
    }

    public function setMdays(ConfigSaisonDates $model): self
    {
        $model
            ->setFromMday($model)
            ->setUntilMday($model)
        ;
        return $model;
    }

    public function setFromMday($model): self
    {
//        $table->attributes['from_month_day'] = $table->from_month . $table->from_day;
        $model->from_mday = $model->from_month . $model->from_day;
        return $model;
    }

    public function setUntilMday(ConfigSaisonDates $model): self
    {
//        $table->attributes['until_month_day'] = $table->until_month . $table->until_day;
        $model->until_mday = $model->until_month . $model->until_day;
        return $model;
    }

    public function setFromDayAttribute(string $val): self
    {
        $this->attributes['from_day'] = (strlen($val) < 2) ? "0$val" : $val;
        return $this;
    }

    public function setUntilDayAttribute($val): self
    {
        $this->attributes['until_day'] = (strlen($val) < 2) ? "0$val" : $val;
        return $this;
    }

    /**
     * @param $key
     * @return string
     */
    public function getStrFromAttribute()
    {
        Carbon::setLocale('de');
        return $this->from_day . '. ' . Carbon::createFromFormat('m', $this->from_month)->monthName;
    }

    /**
     * @param $key
     * @return string
     */
    public function getStrUntilAttribute()
    {
        Carbon::setLocale('de');
        return $this->until_day . '. ' . Carbon::createFromFormat('m', $this->until_month)->monthName;
    }

    /**
     * @return Carbon
     */
    public function getFromAttribute(): Carbon
    {
        $today = Carbon::today();
        $year = ($this->from_month <= $this->until_month) ? $today->year : $today->subYear()->format('Y');

        return Carbon::create($year . '-' . $this->from_month . '-' . $this->from_day);
    }

    /**
     * @return Carbon
     */
    public function getUntilAttribute(): Carbon
    {
        $year = ($this->from->month >= $this->until_month) ? $this->from->copy()->addYear()->format('Y') : $this->from->year;

        return Carbon::create($year . '-' . $this->until_month . '-' . $this->until_day);
    }

    /**
     * @return string
     */
    public function getValidFromAttribute()
    {
        return $this->from->format('Y-m-d');
    }

    /**
     *
     */
    public function getValidUntilAttribute()
    {
        return $this->until->format('Y-m-d');
    }
}

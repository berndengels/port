<?php

namespace App\Models;

use Database\Factories\ConfigSaisonDatesFactory;
use Eloquent;
use Carbon\Carbon;
use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigSaisonDates
 *
 * @property int $id
 * @property string $name
 * @property int $from_day
 * @property int $from_month
 * @property int $until_day
 * @property int $until_month
 * @property-read mixed $str_from
 * @property-read mixed $str_until
 * @property Carbon $from
 * @property Carbon $until
 * @method static Builder|ConfigSaisonDates newModelQuery()
 * @method static Builder|ConfigSaisonDates newQuery()
 * @method static Builder|ConfigSaisonDates query()
 * @method static Builder|ConfigSaisonDates whereFromDay($value)
 * @method static Builder|ConfigSaisonDates whereFromMonth($value)
 * @method static Builder|ConfigSaisonDates whereId($value)
 * @method static Builder|ConfigSaisonDates whereName($value)
 * @method static Builder|ConfigSaisonDates whereUntilDay($value)
 * @method static Builder|ConfigSaisonDates whereUntilMonth($value)
 * @mixin Eloquent
 * @property-read string $valid_from
 * @property-read mixed $valid_until
 * @property int|null $from_mday
 * @property int|null $until_mday
 * @method static Builder|ConfigSaisonDates whereFromMday($value)
 * @method static Builder|ConfigSaisonDates whereUntilMday($value)
 * @property string|null $key
 * @property string|null $mode
 * @property-read ConfigBoatPrice|null $boatPrice
 * @property-read ConfigDailyPrice|null $dailyPrice
 * @method static ConfigSaisonDatesFactory factory(...$parameters)
 * @method static Builder|ConfigSaisonDates whereKey($value)
 * @method static Builder|ConfigSaisonDates whereMode($value)
 */
class ConfigSaisonDates extends BaseModel
{
    use HasFactory,
        ClearCache;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_SAISON_DATES,
        AppCache::KEY_OPTIONS_DATA_SAISON_DATES,
    ];

    /**
     * @var string
     */
    protected $table = 'config_saison_dates';
    /**
     * @var string[]
     */
    protected $guarded = ['id'];
    /**
     * @var string[]
     */
    protected $appends = [
        'from',
        'until',
        'strFrom',
        'strUntil',
        'validFrom',
        'validUntil',
    ];
    /**
     * @var bool
     */
    public $timestamps = false;

    protected $casts = [
        'from'  => 'date:Y-m-d',
        'until' => 'date:Y-m-d',
    ];

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

    public function boatPrice()
    {
        return $this->hasOne(ConfigBoatPrice::class, 'saison_date_id', 'id');
    }

    public function dailyPrice()
    {
        return $this->hasOne(ConfigDailyPrice::class, 'saison_date_id', 'id');
    }
}

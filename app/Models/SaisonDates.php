<?php

namespace App\Models;

use Carbon\Carbon;
use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\SaisonDates
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
 * @method static Builder|SaisonDates newModelQuery()
 * @method static Builder|SaisonDates newQuery()
 * @method static Builder|SaisonDates query()
 * @method static Builder|SaisonDates whereFromDay($value)
 * @method static Builder|SaisonDates whereFromMonth($value)
 * @method static Builder|SaisonDates whereId($value)
 * @method static Builder|SaisonDates whereName($value)
 * @method static Builder|SaisonDates whereUntilDay($value)
 * @method static Builder|SaisonDates whereUntilMonth($value)
 * @mixin Eloquent
 * @property-read string $valid_from
 * @property-read mixed $valid_until
 */
class SaisonDates extends Model
{
    use HasFactory,
        ClearCache;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_SAISON_DATES,
        AppCache::KEY_OPTIONS_DATA_SAISON_DATES,
    ];

    protected static function booted()
    {
        static::created(function ($table) {
            $table->from_month_day  = $table->from_month . $table->from_day;
            $table->until_month_day = $table->until_month . $table->until_day;
        });
        static::updated(function ($table) {
            $table->from_month_day  = $table->from_month . $table->from_day;
            $table->until_month_day = $table->until_month . $table->until_day;
        });
        static::saved(function ($table) {
            $table->from_month_day  = $table->from_month . $table->from_day;
            $table->until_month_day = $table->until_month . $table->until_day;
        });
    }

    /**
     * @var string
     */
    protected $table = 'saison_dates';
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
        'fromMonthDay',
        'untilMonthDay',
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
        $year = ($this->from_month < $this->until_month) ? $today->year : $today->subYear()->format('Y');

        return Carbon::create($year . '-' . $this->from_month . '-' . $this->from_day);
    }

    /**
     * @return Carbon
     */
    public function getUntilAttribute(): Carbon
    {
        $today = Carbon::today();
        $year = ($this->from->month > $this->until_month) ? $this->from->addYear()->format('Y') : $this->from->year;

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

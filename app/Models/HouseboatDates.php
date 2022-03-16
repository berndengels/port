<?php

namespace App\Models;

use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\HasYearMonthOptions;
use App\Traits\Models\Filter\YearMonthFilter;
use App\Traits\Models\HasDailyPrice;
use App\Traits\Models\HasFromUntilDates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

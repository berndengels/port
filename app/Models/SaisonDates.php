<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @method static \Illuminate\Database\Eloquent\Builder|SaisonDates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaisonDates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SaisonDates query()
 * @method static \Illuminate\Database\Eloquent\Builder|SaisonDates whereFromDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaisonDates whereFromMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaisonDates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaisonDates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaisonDates whereUntilDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SaisonDates whereUntilMonth($value)
 * @mixin \Eloquent
 */
class SaisonDates extends Model
{
    use HasFactory;

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
    protected $appends = ['from', 'until', 'strFrom', 'strUntil', 'validFrom', 'validUntil'];
    /**
     * @var bool
     */
    public $timestamps = false;

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
        $year = ($this->from_month < $this->until_month) ? $today->year : $today->subYear();

        return Carbon::create($year . '-' . $this->from_month . '-' . $this->from_day);
    }

    /**
     * @return Carbon
     */
    public function getUntilAttribute(): Carbon
    {
        $today = Carbon::today();
        $year = ($this->until_month < $this->from_month) ? $today->addYear() : $today->year;

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

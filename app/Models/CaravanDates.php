<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\CaravanDates
 *
 * @property int $id
 * @property int $caravan_id
 * @property int $persons
 * @property Carbon $from
 * @property Carbon $until
 * @property int|null $electrical_connection
 * @property int $price
 * @property-read Caravan $caravan
 * @method static Builder|CaravanDates newModelQuery()
 * @method static Builder|CaravanDates newQuery()
 * @method static Builder|CaravanDates query()
 * @method static Builder|CaravanDates whereCaravanId($value)
 * @method static Builder|CaravanDates whereElectricalConnection($value)
 * @method static Builder|CaravanDates whereFrom($value)
 * @method static Builder|CaravanDates whereId($value)
 * @method static Builder|CaravanDates wherePersons($value)
 * @method static Builder|CaravanDates wherePrice($value)
 * @method static Builder|CaravanDates whereUntil($value)
 * @mixin Eloquent
 * @property int|null $electric
 * @property string $prices
 * @property-read mixed $days
 * @method static Builder|CaravanDates whereElectric($value)
 * @method static Builder|CaravanDates wherePrices($value)
 * @method static Builder|CaravanDates getMonthsByYears($from = null, $until = null)
 */
class CaravanDates extends Model
{
    use HasFactory;

    protected $table = 'caravan_dates';
    protected $guarded = [];
    protected $dates = ['from','until'];
    protected $dateFormat = 'Y-m-d';
    protected $appends = ['days'];

    public $timestamps = false;

    public function caravan()
    {
        return $this->belongsTo(Caravan::class);
    }

    public function getDaysAttribute() {
        if($this->from && $this->until) {
            return $this->from->diffInDays($this->until);
        }
        return null;
    }

    /**
     * Scope a query to get.
     *
     * @param Builder $query
     * @return array
     */
    public function scopeGetMonthsByYears(Builder $query, $from = null, $until = null) {
        $query->selectRaw("DISTINCT MONTH(`from`) month, DATE_FORMAT(`from`, '%M', 'de_DE') monthname, YEAR(`from`) year");

        if($from) {
            $query->whereDate('from','>=', $from);
        }
        if($until) {
            $query->whereDate('until','<=', $until);
        }
        $data = $query
            ->orderBy('year')
            ->orderBy('month')
            ->get()
        ;
        $result = [];
        foreach($data as $date) {
            $result[$date->year][] = [
                'month'     => $date->month,
                'monthname' => $date->monthname,
            ];
        }
        return $result;
    }

    /**
     * Scope a query to get.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopePageList(Builder $query) {
        return $query->with('caravan')->orderBy('from','DESC');
    }
}

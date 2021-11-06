<?php

namespace App\Models;

use Eloquent;
use Illuminate\Support\Carbon;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\CaravanFilter;
use App\Traits\Models\Filter\YearMonthFilter;
use Database\Factories\CaravanDatesFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\JoinClause;

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
 * @method static CaravanDatesFactory factory(...$parameters)
 * @method static Builder|CaravanDates pageList()
 * @property int|null $day_price
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method static Builder|CaravanDates (?int $caravanId = null)
 * @method static Builder|CaravanDates caravanByDates(?int $caravanId = null)
 * @method static Builder|CaravanDates dublicates()
 * @method static Builder|CaravanDates fromYearMonth(?string $year = null, ?string $month = null)
 * @method static Builder|CaravanDates whereDayPrice($value)
 * @method static Builder|CaravanDates caravan(?int $caravanId = null)
 */
class CaravanDates extends BaseModel
{
    use HasFactory, CaravanFilter, YearMonthFilter, ClearCache;

    protected $table = 'caravan_dates';
    protected $guarded = ['id'];
    protected $dates = ['from','until'];
    protected $dateFormat = 'Y-m-d';
    protected $appends = ['days','validFrom','validUntil'];

    public $timestamps = false;

    protected $casts = [
        'persons'   => 'integer',
        'price'     => 'integer',
    ];

    public function caravan()
    {
        return $this->belongsTo(Caravan::class);
    }

    public function scopeDublicates(Builder $builder)
    {
        $builder->selectRaw('cd.*, c.carnumber, c.carlength, c.email, COUNT(cd.caravan_id) anzahl')
            ->from($this->table, 'cd')
            ->join('caravans AS c', 'c.id','=', 'cd.caravan_id')
            ->join('caravan_dates AS cd2', function (JoinClause $j){
                return $j
                    ->whereRaw('cd2.id != cd.id ')
                    ->whereRaw('cd2.caravan_id = cd.caravan_id')
                    ->whereRaw('(DATE(cd.from) BETWEEN cd2.from AND cd2.until OR DATE(cd.until) BETWEEN cd2.from AND cd2.until)')
                    ;
            })
            ->groupBy(['cd.caravan_id'])
            ->having('anzahl','>', 1)
        ;
        return $builder;
    }

    public function getValidFromAttribute() {
        return $this->from->format('Y-m-d');
    }

    public function getValidUntilAttribute() {
        return $this->until->format('Y-m-d');
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
        return $query->with('caravan')->orderBy('id','DESC');
    }
}

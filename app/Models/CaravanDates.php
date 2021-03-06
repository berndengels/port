<?php

namespace App\Models;

use App\Contracts\Models\IDatePrice;
use App\Traits\Models\Filter\HasYearMonthOptions;
use App\Traits\Models\HasDailyPrice;
use App\Traits\Models\HasFromUntilDates;
use App\Traits\Models\UseBooleanIcon;
use Eloquent;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\CaravanFilter;
use App\Traits\Models\Filter\YearMonthFilter;
use Database\Factories\CaravanDatesFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\JoinClause;
use Spatie\Period\Period;

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
 * @property-read int|null $prices_count
 * @method static Builder|CaravanDates dailyPrices()
 * @property int $is_paid
 * @method static Builder|CaravanDates whereIsPaid($value)
 * @method static Builder|CaravanDates caravan(?int $caravanId = null)
 */
class CaravanDates extends BaseModel
{
    use CaravanFilter;
    use ClearCache;
    use HasDailyPrice;
    use HasFactory;
    use HasFromUntilDates;
    use HasYearMonthOptions;
    use UseBooleanIcon;
    use YearMonthFilter;

    protected $table = 'caravan_dates';
    protected $guarded = ['id'];
    protected $dates = ['from','until'];
    protected $appends = ['days','validFrom','validUntil'];

    public $timestamps = false;

    protected $casts = [
        'persons'   => 'integer',
        'price'     => 'integer',
        'from'      => 'date:Y-m-d',
        'until'     => 'date:Y-m-d',
        'is_paid'   => 'boolean',
    ];

    public function caravan()
    {
        return $this->belongsTo(Caravan::class);
    }

    public function scopeDublicates(Builder $builder)
    {
        $builder->selectRaw('cd.*, c.carnumber, c.carlength, c.email, COUNT(cd.caravan_id) anzahl')
            ->from($this->table, 'cd')
            ->join('caravans AS c', 'c.id', '=', 'cd.caravan_id')
            ->join(
                'caravan_dates AS cd2', function (JoinClause $j) {
                    return $j
                        ->whereRaw('cd2.id != cd.id ')
                        ->whereRaw('cd2.caravan_id = cd.caravan_id')
                        ->whereRaw('(DATE(cd.from) BETWEEN cd2.from AND cd2.until OR DATE(cd.until) BETWEEN cd2.from AND cd2.until)');
                }
            )
            ->groupBy(['cd.caravan_id'])
            ->having('anzahl', '>', 1);
        return $builder;
    }

    /**
     * Scope a query to get.
     *
     * @param  Builder $query
     * @return Builder
     */
    public function scopePageList(Builder $query)
    {
        return $query->with('caravan')->orderBy('id', 'DESC');
    }
}

<?php

namespace App\Models;

use Eloquent;
use App\Traits\Models\Filter\HasYearMonthOptions;
use App\Traits\Models\HasDailyPrice;
use App\Traits\Models\HasFromUntilDates;
use App\Traits\Models\HasPrice;
use App\Traits\Models\UseBooleanIcon;
use Illuminate\Support\Carbon;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\CaravanFilter;
use App\Traits\Models\Filter\YearMonthFilter;
use Database\Factories\CaravanDatesFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\JoinClause;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\CaravanDates
 *
 * @property int $id
 * @property int $caravan_id
 * @property Carbon $from
 * @property Carbon $until
 * @property int $persons
 * @property int|null $electric
 * @property int|null $day_price
 * @property int $price
 * @property mixed $prices
 * @property bool $is_paid
 * @property-read Caravan $caravan
 * @property-read mixed $days
 * @property-read mixed $price_data
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method static Builder|CaravanDates caravan(?int $caravanId = null)
 * @method static Builder|CaravanDates caravanById(?int $caravanId = null)
 * @method static Builder|CaravanDates dailyPrices()
 * @method static Builder|CaravanDates datesBetween(?\Carbon\Carbon $from = null, ?\Carbon\Carbon $until = null)
 * @method static Builder|CaravanDates dublicates()
 * @method static CaravanDatesFactory factory($count = null, $state = [])
 * @method static Builder|CaravanDates fromYearMonth(?string $year = null, ?string $month = null)
 * @method static Builder|CaravanDates newModelQuery()
 * @method static Builder|CaravanDates newQuery()
 * @method static Builder|CaravanDates pageList()
 * @method static Builder|CaravanDates query()
 * @method static Builder|CaravanDates sortable($defaultParameters = null)
 * @method static Builder|CaravanDates whereCaravanId($value)
 * @method static Builder|CaravanDates whereDayPrice($value)
 * @method static Builder|CaravanDates whereElectric($value)
 * @method static Builder|CaravanDates whereFrom($value)
 * @method static Builder|CaravanDates whereId($value)
 * @method static Builder|CaravanDates whereIsPaid($value)
 * @method static Builder|CaravanDates wherePersons($value)
 * @method static Builder|CaravanDates wherePrice($value)
 * @method static Builder|CaravanDates wherePrices($value)
 * @method static Builder|CaravanDates whereUntil($value)
 * @mixin Eloquent
 */
class CaravanDates extends BaseModel
{
    use CaravanFilter,
        ClearCache,
        HasPrice,
        HasDailyPrice,
        HasFactory,
        HasFromUntilDates,
        UseBooleanIcon,
        YearMonthFilter,
        Sortable;

    protected $table = 'caravan_dates';
    protected $guarded = ['id'];
    protected $dates = ['from','until'];
    protected $appends = ['days','validFrom','validUntil'];
    public $sortable = ['caravan.carnumber','from','until'];

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

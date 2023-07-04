<?php

namespace App\Models;

use Eloquent;
use Carbon\Carbon;
use Spatie\Period\Period;
use App\Traits\Models\HasFromUntilDates;
use Database\Factories\ConfigSaisonRentDatesFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ConfigSaisonRentDates
 *
 * @property int $id
 * @property int $config_saison_rent_id
 * @property string|null $name
 * @property string|null $holiday
 * @property \Illuminate\Support\Carbon $from
 * @property \Illuminate\Support\Carbon $until
 * @property-read mixed $days
 * @property-read Period $period
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @property-read \App\Models\ConfigSaisonRent $saison
 * @method static Builder|ConfigSaisonRentDates containsDates(\Carbon\Carbon $from, \Carbon\Carbon $until)
 * @method static Builder|ConfigSaisonRentDates datesBetween(?\Carbon\Carbon $from = null, ?\Carbon\Carbon $until = null)
 * @method static \Database\Factories\ConfigSaisonRentDatesFactory factory($count = null, $state = [])
 * @method static Builder|ConfigSaisonRentDates newModelQuery()
 * @method static Builder|ConfigSaisonRentDates newQuery()
 * @method static Builder|ConfigSaisonRentDates query()
 * @method static Builder|ConfigSaisonRentDates whereConfigSaisonRentId($value)
 * @method static Builder|ConfigSaisonRentDates whereFrom($value)
 * @method static Builder|ConfigSaisonRentDates whereHoliday($value)
 * @method static Builder|ConfigSaisonRentDates whereId($value)
 * @method static Builder|ConfigSaisonRentDates whereName($value)
 * @method static Builder|ConfigSaisonRentDates whereUntil($value)
 * @mixin Eloquent
 */
class ConfigSaisonRentDates extends Model
{
    use HasFactory;
    use HasFromUntilDates;

    protected $table = 'config_saison_rent_dates';
    protected $guarded = ['id'];
    protected $dates = ['from','until'];
    protected $appends = ['period'];
    protected $casts = [
        'from'  => 'date:Y-m-d',
        'until' => 'date:Y-m-d',
    ];
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function saison()
    {
        return $this->belongsTo(ConfigSaisonRent::class, 'config_saison_rent_id', 'id');
    }

    /**
     * @return Period
     */
    public function getPeriodAttribute():Period
    {
        return Period::make($this->from, $this->until);
    }

    public function scopeContainsDates(Builder $query, Carbon $from, Carbon $until): Builder
    {
        return $query
            ->whereDate('from', '>=', $from)
            ->whereDate('until', '<=', $until)

            ->orWhereDate('from', '<=', $from)
            ->whereDate('until', '<=', $until)

            ->orWhereDate('until', '>=', $until)
            ->whereDate('from', '<=', $until)
            ;
    }
}

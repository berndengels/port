<?php

namespace App\Models;

use App\Traits\Models\HasFromUntilDates;
use Database\Factories\ConfigSaisonRentDatesFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\ConfigSaisonRentDates
 *
 * @property int $id
 * @property int $config_saison_rent_id
 * @property int|null $from_day
 * @property int|null $from_month
 * @property int|null $until_day
 * @property int|null $until_month
 * @property int|null $from_mday
 * @property int|null $until_mday
 * @property-read ConfigSaisonRent $saison
 * @method static ConfigSaisonRentDatesFactory factory(...$parameters)
 * @method static Builder|ConfigSaisonRentDates newModelQuery()
 * @method static Builder|ConfigSaisonRentDates newQuery()
 * @method static Builder|ConfigSaisonRentDates query()
 * @method static Builder|ConfigSaisonRentDates whereConfigSaisonRentId($value)
 * @method static Builder|ConfigSaisonRentDates whereFromDay($value)
 * @method static Builder|ConfigSaisonRentDates whereFromMday($value)
 * @method static Builder|ConfigSaisonRentDates whereFromMonth($value)
 * @method static Builder|ConfigSaisonRentDates whereId($value)
 * @method static Builder|ConfigSaisonRentDates whereUntilDay($value)
 * @method static Builder|ConfigSaisonRentDates whereUntilMday($value)
 * @method static Builder|ConfigSaisonRentDates whereUntilMonth($value)
 * @mixin Eloquent
 * @property string|null $holiday
 * @property Carbon $from
 * @property Carbon $until
 * @property-read mixed $days
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method static Builder|ConfigSaisonRentDates whereFrom($value)
 * @method static Builder|ConfigSaisonRentDates whereHoliday($value)
 * @method static Builder|ConfigSaisonRentDates whereUntil($value)
 */
class ConfigSaisonRentDates extends Model
{
    use HasFactory;
    use HasFromUntilDates;

    protected $table = 'config_saison_rent_dates';
    protected $guarded = ['id'];
    protected $dates = ['from','until'];
    public $timestamps = false;

    public function saison()
    {
        return $this->belongsTo(ConfigSaisonRent::class, 'config_saison_rent_id', 'id');
    }
}

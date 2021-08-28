<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
        return $this->from->diffInDays($this->until);
    }
}

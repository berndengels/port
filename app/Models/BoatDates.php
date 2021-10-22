<?php

namespace App\Models;

use Eloquent;
use App\Traits\Models\ClearsResponseCache;
use App\Traits\Models\Events\FireEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\BoatDates
 *
 * @method static Builder|BoatDates newModelQuery()
 * @method static Builder|BoatDates newQuery()
 * @method static Builder|BoatDates query()
 * @mixin Eloquent
 * @property int $id
 * @property int $boat_id
 * @property string $modus
 * @property Carbon $from
 * @property Carbon $until
 * @property int $price
 * @property string $prices
 * @property-read Boat $boat
 * @property-read mixed $is_cleaned
 * @property-read mixed $is_craned
 * @property-read mixed $is_mast_craned
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @method static Builder|BoatDates whereBoatId($value)
 * @method static Builder|BoatDates whereFrom($value)
 * @method static Builder|BoatDates whereId($value)
 * @method static Builder|BoatDates whereModus($value)
 * @method static Builder|BoatDates wherePrice($value)
 * @method static Builder|BoatDates wherePrices($value)
 * @method static Builder|BoatDates whereUntil($value)
 */
class BoatDates extends Model
{
    use HasFactory, ClearsResponseCache, FireEvents;

    protected $table = 'boat_dates';
    protected $guarded = ['id'];
    protected $dates = ['from', 'until'];
    protected $dateFormat = 'Y-m-d';
    protected $appends = ['validFrom','validUntil','isCraned','isMastCraned','isCleaned'];
    public $timestamps = false;

    public function boat() {
        return $this->belongsTo(Boat::class);
    }

    public function pricesEncoded() {
        return json_decode($this->prices);
    }
    public function getValidFromAttribute() {
        return $this->from->format('Y-m-d');
    }

    public function getValidUntilAttribute() {
        return $this->until->format('Y-m-d');
    }

    public function getIsCranedAttribute()
    {
        return (isset($this->pricesEncoded()->crane) && $this->pricesEncoded()->crane > 0) ? true : false;
    }

    public function getIsMastCranedAttribute()
    {
        return (isset($this->pricesEncoded()->mast_crane) && $this->pricesEncoded()->mast_crane > 0) ? true : false;
    }
    public function getIsCleanedAttribute()
    {
        return (isset($this->pricesEncoded()->cleaning) && $this->pricesEncoded()->cleaning > 0) ? true : false;
    }
}

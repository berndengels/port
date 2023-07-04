<?php

namespace App\Models;

use App\Traits\Models\ClearCache;
use Database\Factories\ConfigBoatPriceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ConfigBoatPrice
 *
 * @property int $id
 * @property string|null $name
 * @property int $saison_date_id
 * @property int $price_type_id
 * @property float $price_factor
 * @property-read \App\Models\ConfigPriceType $priceType
 * @property-read \App\Models\ConfigSaisonDates $saison
 * @method static \Database\Factories\ConfigBoatPriceFactory factory($count = null, $state = [])
 * @method static Builder|ConfigBoatPrice newModelQuery()
 * @method static Builder|ConfigBoatPrice newQuery()
 * @method static Builder|ConfigBoatPrice query()
 * @method static Builder|ConfigBoatPrice whereId($value)
 * @method static Builder|ConfigBoatPrice whereName($value)
 * @method static Builder|ConfigBoatPrice wherePriceFactor($value)
 * @method static Builder|ConfigBoatPrice wherePriceTypeId($value)
 * @method static Builder|ConfigBoatPrice whereSaisonDateId($value)
 * @mixin Eloquent
 */
class ConfigBoatPrice extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'config_boat_prices';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function saison()
    {
        return $this->belongsTo(ConfigSaisonDates::class, 'saison_date_id');
    }

    public function priceType()
    {
        return $this->belongsTo(ConfigPriceType::class, 'price_type_id');
    }
}

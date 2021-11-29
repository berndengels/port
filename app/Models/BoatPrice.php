<?php

namespace App\Models;

use App\Traits\Models\ClearCache;
use Database\Factories\BoatPriceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BoatPrice
 *
 * @property int $id
 * @property int $saison_date_id
 * @property int $price_type_id
 * @property float $price_factor
 * @property-read PriceType $priceType
 * @property-read SaisonDates $saison
 * @method static BoatPriceFactory factory(...$parameters)
 * @method static Builder|BoatPrice newModelQuery()
 * @method static Builder|BoatPrice newQuery()
 * @method static Builder|BoatPrice query()
 * @method static Builder|BoatPrice whereId($value)
 * @method static Builder|BoatPrice wherePriceFactor($value)
 * @method static Builder|BoatPrice wherePriceTypeId($value)
 * @method static Builder|BoatPrice whereSaisonDateId($value)
 * @mixin Eloquent
 */
class BoatPrice extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'boat_prices';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function saison()
    {
        return $this->belongsTo(SaisonDates::class, 'saison_date_id');
    }

    public function priceType()
    {
        return $this->belongsTo(PriceType::class, 'price_type_id');
    }
}

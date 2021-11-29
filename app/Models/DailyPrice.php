<?php

namespace App\Models;

use App\Traits\Models\ClearCache;
use Database\Factories\DailyPriceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DailyPrice
 *
 * @property int $id
 * @property string $model
 * @property int $saison_date_id
 * @property int $price_type_id
 * @property float|null $from_unit
 * @property float|null $until_unit
 * @property string $price
 * @property-read Model|Eloquent $affordable
 * @property-read mixed $basename
 * @property-read PriceType $priceType
 * @property-read SaisonDates $saison
 * @method static DailyPriceFactory factory(...$parameters)
 * @method static Builder|DailyPrice newModelQuery()
 * @method static Builder|DailyPrice newQuery()
 * @method static Builder|DailyPrice query()
 * @method static Builder|DailyPrice whereFromUnit($value)
 * @method static Builder|DailyPrice whereId($value)
 * @method static Builder|DailyPrice whereModel($value)
 * @method static Builder|DailyPrice wherePrice($value)
 * @method static Builder|DailyPrice wherePriceTypeId($value)
 * @method static Builder|DailyPrice whereSaisonDateId($value)
 * @method static Builder|DailyPrice whereUntilUnit($value)
 * @mixin Eloquent
 */
class DailyPrice extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'daily_prices';
    protected $guarded = ['id'];
    protected $appends = ['basename'];
    public $timestamps = false;

    public function getBasenameAttribute()
    {
        return class_basename($this->model);
    }
/*
    public function affordable()
    {
        return $this->morphTo();
    }
*/
    public function saison()
    {
        return $this->belongsTo(SaisonDates::class,'saison_date_id');
    }

    public function priceType()
    {
        return $this->belongsTo(PriceType::class, 'price_type_id');
    }
}

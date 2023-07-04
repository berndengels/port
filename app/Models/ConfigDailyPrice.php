<?php

namespace App\Models;

use App\Traits\Models\ClearCache;
use Database\Factories\ConfigDailyPriceFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ConfigDailyPrice
 *
 * @property int $id
 * @property string $model
 * @property int $saison_date_id
 * @property int $price_type_id
 * @property float|null $from_unit
 * @property float|null $until_unit
 * @property string $price
 * @property-read mixed $basename
 * @property-read \App\Models\ConfigPriceType $priceType
 * @property-read \App\Models\ConfigSaisonDates $saison
 * @method static \Database\Factories\ConfigDailyPriceFactory factory($count = null, $state = [])
 * @method static Builder|ConfigDailyPrice newModelQuery()
 * @method static Builder|ConfigDailyPrice newQuery()
 * @method static Builder|ConfigDailyPrice query()
 * @method static Builder|ConfigDailyPrice whereFromUnit($value)
 * @method static Builder|ConfigDailyPrice whereId($value)
 * @method static Builder|ConfigDailyPrice whereModel($value)
 * @method static Builder|ConfigDailyPrice wherePrice($value)
 * @method static Builder|ConfigDailyPrice wherePriceTypeId($value)
 * @method static Builder|ConfigDailyPrice whereSaisonDateId($value)
 * @method static Builder|ConfigDailyPrice whereUntilUnit($value)
 * @mixin Eloquent
 */
class ConfigDailyPrice extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'config_daily_prices';
    protected $guarded = ['id'];
    protected $appends = ['basename'];
    public $timestamps = false;

    public function getBasenameAttribute()
    {
        return class_basename($this->model);
    }

    public function saison()
    {
        return $this->belongsTo(ConfigSaisonDates::class,'saison_date_id');
    }

    public function priceType()
    {
        return $this->belongsTo(ConfigPriceType::class, 'price_type_id');
    }
}

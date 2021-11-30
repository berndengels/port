<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigPriceComponent
 *
 * @property int $id
 * @property int $price_type_id
 * @property int|null $config_service_id
 * @property string $name
 * @property string $key
 * @property int|null $unit_inclusive
 * @property string $unit_price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConfigHasPriceComponent[] $entities
 * @property-read int|null $entities_count
 * @property-read \App\Models\ConfigPriceType $priceType
 * @property-read \App\Models\ConfigService|null $service
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent whereConfigServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent wherePriceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent whereUnitInclusive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigPriceComponent whereUnitPrice($value)
 * @mixin \Eloquent
 */
class ConfigPriceComponent extends BaseModel
{
    use HasFactory;

    protected $table = 'config_price_components';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function priceType()
    {
        return $this->belongsTo(ConfigPriceType::class, 'price_type_id');
    }

    public function service()
    {
        return $this->belongsTo(ConfigService::class, 'config_service_id');
    }

    public function entities()
    {
        return $this->morphMany(ConfigHasPriceComponent::class, 'config_price_component_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigHasPriceComponent
 *
 * @property int $id
 * @property int $has_price_component_id
 * @property string $has_price_component_type
 * @property int $config_price_component_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $hasPriceComponents
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigHasPriceComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigHasPriceComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigHasPriceComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigHasPriceComponent whereConfigPriceComponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigHasPriceComponent whereHasPriceComponentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigHasPriceComponent whereHasPriceComponentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigHasPriceComponent whereId($value)
 * @mixin \Eloquent
 */
class ConfigHasPriceComponent extends BaseModel
{
    use HasFactory;

    protected $table = 'config_has_price_components';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function hasPriceComponents()
    {
        return $this->morphTo();
    }

    public function components()
    {
        return $this->hasMany(ConfigPriceComponent::class, 'config_price_component_id');
    }
}

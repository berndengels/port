<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ConfigEntityType
 *
 * @property int $id
 * @property string|null $model
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConfigHasPriceComponent[] $priceComponents
 * @property-read int|null $price_components_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConfigPriceComponent[] $prices
 * @property-read int|null $prices_count
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigEntityType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigEntityType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigEntityType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigEntityType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConfigEntityType whereModel($value)
 * @mixin \Eloquent
 */
class ConfigEntityType extends Model
{
    use HasFactory;

    protected $table = 'config_entity_types';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function priceComponents()
    {
        return $this->morphMany(ConfigHasPriceComponent::class, 'has_price_component');
    }
/*
    public function entityPriceComponents()
    {
        return $this->belongsToMany(ConfigPriceComponent::class);
    }
*/
}

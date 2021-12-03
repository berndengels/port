<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ConfigEntityType
 *
 * @property int $id
 * @property string|null $model
 * @property-read Collection|ConfigHasPriceComponent[] $priceComponents
 * @property-read int|null $price_components_count
 * @property-read Collection|ConfigPriceComponent[] $prices
 * @property-read int|null $prices_count
 * @method static Builder|ConfigEntityType newModelQuery()
 * @method static Builder|ConfigEntityType newQuery()
 * @method static Builder|ConfigEntityType query()
 * @method static Builder|ConfigEntityType whereId($value)
 * @method static Builder|ConfigEntityType whereModel($value)
 * @mixin Eloquent
 */
class ConfigEntityType extends Model
{
    use HasFactory;

    protected $table = 'config_entity_types';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function priceComponents()
    {
        return $this->belongsToMany(
            ConfigPriceComponent::class,
            'config_has_price_components',
            'entity_type_id',
            'id'
        )->wherePivot('');
    }

    public function getPriceComponents(string $entity)
    {
        return $this
            ->priceComponents()
            ->whereHas('entities', fn($entities) => dd($entities))
            ;
    }
}

<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ConfigEntityFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigEntity
 *
 * @property int $id
 * @property string|null $model
 * @property-read Collection|ConfigHasPriceComponent[] $priceComponents
 * @property-read int|null $price_components_count
 * @property-read Collection|ConfigPriceComponent[] $prices
 * @property-read int|null $prices_count
 * @method static Builder|ConfigEntity newModelQuery()
 * @method static Builder|ConfigEntity newQuery()
 * @method static Builder|ConfigEntity query()
 * @method static Builder|ConfigEntity whereId($value)
 * @method static Builder|ConfigEntity whereModel($value)
 * @mixin Eloquent
 * @method static ConfigEntityFactory factory(...$parameters)
 * @method static Builder|ConfigEntity getPriceComponents(string $entity)
 */
class ConfigEntity extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'config_entities';
    /**
     * @var string[]
     */
    protected $guarded = ['id'];
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function priceComponents()
    {
        return $this->belongsToMany(
            ConfigPriceComponent::class,
            'config_has_price_components',
            'entity_id',
            'price_component_id'
        );
    }
}

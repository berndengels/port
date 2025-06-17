<?php

namespace App\Models;

use Database\Factories\ConfigPriceComponentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
 * @property float $unit_price
 * @property-read Collection<int, ConfigEntity> $entities
 * @property-read int|null $entities_count
 * @property-read ConfigPriceType $priceType
 * @property-read ConfigService|null $service
 * @method static ConfigPriceComponentFactory factory($count = null, $state = [])
 * @method static Builder|ConfigPriceComponent newModelQuery()
 * @method static Builder|ConfigPriceComponent newQuery()
 * @method static Builder|ConfigPriceComponent query()
 * @method static Builder|ConfigPriceComponent whereConfigServiceId($value)
 * @method static Builder|ConfigPriceComponent whereId($value)
 * @method static Builder|ConfigPriceComponent whereKey($value)
 * @method static Builder|ConfigPriceComponent whereName($value)
 * @method static Builder|ConfigPriceComponent wherePriceTypeId($value)
 * @method static Builder|ConfigPriceComponent whereUnitInclusive($value)
 * @method static Builder|ConfigPriceComponent whereUnitPrice($value)
 * @mixin Eloquent
 */
class ConfigPriceComponent extends BaseModel
{
    use HasFactory;

    protected $table = 'config_price_components';
    protected $with = ['priceType'];
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $casts = [
        'unit_price'    => 'float',
		'unit_from'     => 'int',
		'unit_until'    => 'int',
    ];

	public function unitRangeType()
	{
		return $this->belongsTo(ConfigUnitRangeType::class, 'config_unit_range_type_id', 'id');
	}

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
        return $this->belongsToMany(
            ConfigEntity::class,
            'config_has_price_components',
            'price_component_id',
            'entity_id'
        );
    }
}

<?php

namespace App\Models;

use App\Libs\Prices\Boat\Services\MaterialPrice;
use Eloquent;
use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Database\Factories\MaterialFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Libs\Calculations\Boat\Material\Quantity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Material
 *
 * @property int $id
 * @property int $material_category_id
 * @property int $price_type_id
 * @property int|null $number
 * @property string $name
 * @property string $price_per_unit
 * @property string|null $fertility
 * @property string|null $fertility_per
 * @property string|null $fertility_unit
 * @property-read MaterialCategory $category
 * @property-read ConfigPriceType $priceType
 * @method static MaterialFactory factory(...$parameters)
 * @method static Builder|Material newModelQuery()
 * @method static Builder|Material newQuery()
 * @method static Builder|Material query()
 * @method static Builder|Material whereFertility($value)
 * @method static Builder|Material whereFertilityPer($value)
 * @method static Builder|Material whereFertilityUnit($value)
 * @method static Builder|Material whereId($value)
 * @method static Builder|Material whereMaterialCategoryId($value)
 * @method static Builder|Material whereName($value)
 * @method static Builder|Material whereNumber($value)
 * @method static Builder|Material wherePricePerUnit($value)
 * @method static Builder|Material wherePriceTypeId($value)
 * @mixin Eloquent
 */
class Material extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'materials';
    protected $guarded = ['id'];
    protected $appends = [];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_MATERIAL,
        AppCache::KEY_OPTIONS_DATA_MATERIAL,
    ];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class ,'material_category_id', 'id');
    }

    public function priceType()
    {
        return $this->belongsTo(ConfigPriceType::class);
    }

    public function getQuantity(Boat $boat)
    {
        return (new Quantity(
            boat: $boat,
            modus: $this->category->modus,
            fertility: $this->fertility,
            fertilityPer: $this->fertility_per,
            fertilityUnit: $this->fertility_unit
        ))->getQuantity();
    }

    public function getMaterialPrice(Boat $boat)
    {
        if(! $this instanceof Material) {
            throw new Exception('wrong model instance');
        }
        return (new MaterialPrice(
            boat: $boat,
            modus: $this->category->modus,
            fertility: $this->fertility,
            fertilityUnit: $this->fertility_unit,
            pricePerUnit: $this->price_per_unit
        ))->getPrice();
    }
}

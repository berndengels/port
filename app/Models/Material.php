<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Database\Factories\MaterialFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
 * @property-read PriceType $priceType
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
        return $this->belongsTo(PriceType::class);
    }
}

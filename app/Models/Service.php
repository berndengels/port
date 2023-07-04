<?php

namespace App\Models;

use Eloquent;
use App\Libs\Prices\Boat\Services\ServicePrice;
use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property int $service_category_id
 * @property int $price_type_id
 * @property string $name
 * @property int|null $quantity
 * @property string $price
 * @property-read \App\Models\ServiceCategory $category
 * @property-read Collection<int, \App\Models\Material> $materials
 * @property-read int|null $materials_count
 * @property-read \App\Models\ConfigPriceType $priceType
 * @method static \Database\Factories\ServiceFactory factory($count = null, $state = [])
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service query()
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereName($value)
 * @method static Builder|Service wherePrice($value)
 * @method static Builder|Service wherePriceTypeId($value)
 * @method static Builder|Service whereQuantity($value)
 * @method static Builder|Service whereServiceCategoryId($value)
 * @mixin Eloquent
 */
class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id', 'id');
    }

    public function priceType(): BelongsTo
    {
        return $this->belongsTo(ConfigPriceType::class);
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(
            Material::class,
            'service_materials'
        );
    }

    public function getServicePrice(Boat $boat)
    {
        return (new ServicePrice(
            boat: $boat,
            modus: $this->category->modus,
            priceType: $this->priceType,
            pricePerUntit: $this->price
        ))->getPrice();
    }
}

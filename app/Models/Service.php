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
 * @property string $name
 * @property string $price
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property-read ServiceCategory $category
 * @property-read Collection|Material[] $materials
 * @property-read int|null $materials_count
 * @method static ServiceFactory factory(...$parameters)
 * @method static Builder|Service newModelQuery()
 * @method static Builder|Service newQuery()
 * @method static Builder|Service query()
 * @method static Builder|Service whereCreatedAt($value)
 * @method static Builder|Service whereId($value)
 * @method static Builder|Service whereName($value)
 * @method static Builder|Service wherePrice($value)
 * @method static Builder|Service whereServiceCategoryId($value)
 * @method static Builder|Service whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $price_type_id
 * @property-read ConfigPriceType $priceType
 * @method static Builder|Service wherePriceTypeId($value)
 * @property int $quantity
 * @method static Builder|Service whereQuantity($value)
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

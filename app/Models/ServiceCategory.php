<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Database\Factories\ServiceCategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ServiceCategory
 *
 * @property int $id
 * @property string $name
 * @property string|null $modus
 * @property-read \App\Models\ConfigPriceType $priceType
 * @method static \Database\Factories\ServiceCategoryFactory factory($count = null, $state = [])
 * @method static Builder|ServiceCategory newModelQuery()
 * @method static Builder|ServiceCategory newQuery()
 * @method static Builder|ServiceCategory query()
 * @method static Builder|ServiceCategory whereId($value)
 * @method static Builder|ServiceCategory whereModus($value)
 * @method static Builder|ServiceCategory whereName($value)
 * @mixin Eloquent
 */
class ServiceCategory extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'service_categories';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_SERVICE_CATEGORY,
        AppCache::KEY_OPTIONS_DATA_SERVICE_CATEGORY,
    ];

    public function priceType()
    {
        return $this->belongsTo(ConfigPriceType::class);
    }
}

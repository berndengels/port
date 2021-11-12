<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Database\Factories\PriceTypeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PriceType
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $unit
 * @method static PriceTypeFactory factory(...$parameters)
 * @method static Builder|PriceType newModelQuery()
 * @method static Builder|PriceType newQuery()
 * @method static Builder|PriceType query()
 * @method static Builder|PriceType whereId($value)
 * @method static Builder|PriceType whereName($value)
 * @method static Builder|PriceType whereType($value)
 * @method static Builder|PriceType whereUnit($value)
 * @mixin Eloquent
 */
class PriceType extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'price_types';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_PRICE_TYPE,
        AppCache::KEY_OPTIONS_DATA_PRICE_TYPE,
    ];

}

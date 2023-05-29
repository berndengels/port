<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Database\Factories\ConfigPriceTypeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ConfigPriceType
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $unit
 * @method static ConfigPriceTypeFactory factory(...$parameters)
 * @method static Builder|ConfigPriceType newModelQuery()
 * @method static Builder|ConfigPriceType newQuery()
 * @method static Builder|ConfigPriceType query()
 * @method static Builder|ConfigPriceType whereId($value)
 * @method static Builder|ConfigPriceType whereName($value)
 * @method static Builder|ConfigPriceType whereType($value)
 * @method static Builder|ConfigPriceType whereUnit($value)
 * @mixin Eloquent
 */
class ConfigPriceType extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'config_price_types';
    protected $guarded = ['id'];
    public $timestamps = false;
	protected $casts = [
		'is_time'	=> 'bool',
	];

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_PRICE_TYPE,
        AppCache::KEY_OPTIONS_DATA_PRICE_TYPE,
    ];
}

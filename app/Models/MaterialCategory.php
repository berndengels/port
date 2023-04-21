<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Database\Factories\MaterialCategoryFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\MaterialCategory
 *
 * @property int $id
 * @property string $name
 * @method static MaterialCategoryFactory factory(...$parameters)
 * @method static Builder|MaterialCategory newModelQuery()
 * @method static Builder|MaterialCategory newQuery()
 * @method static Builder|MaterialCategory query()
 * @method static Builder|MaterialCategory whereId($value)
 * @method static Builder|MaterialCategory whereName($value)
 * @mixin Eloquent
 * @property string|null $modus
 * @method static Builder|MaterialCategory whereModus($value)
 */
class MaterialCategory extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'material_categories';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_MATERIAL_CATEGORY,
        AppCache::KEY_OPTIONS_DATA_MATERIAL_CATEGORY,
    ];

}

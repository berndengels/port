<?php
namespace App\Models;

use App\Libs\AppCache;
use Eloquent;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $code
 * @property string $en
 * @property string $de
 * @property string $es
 * @property string $fr
 * @property string $it
 * @property string $ru
 * @method static Builder|Country newModelQuery()
 * @method static Builder|Country newQuery()
 * @method static Builder|Country query()
 * @method static Builder|Country whereCode($value)
 * @method static Builder|Country whereDe($value)
 * @method static Builder|Country whereEn($value)
 * @method static Builder|Country whereEs($value)
 * @method static Builder|Country whereFr($value)
 * @method static Builder|Country whereId($value)
 * @method static Builder|Country whereIt($value)
 * @method static Builder|Country whereRu($value)
 * @mixin Eloquent
 */
class Country extends BaseModel
{
    use ClearCache;

    protected $table = 'countries';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_COUNTRY,
        AppCache::KEY_OPTIONS_DATA_COUNTRY,
    ];

    /*
    public function caravans() {
        return $this->belongsTo(Caravan::class);
    }
    */
}

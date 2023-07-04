<?php
namespace App\Models;

use Eloquent;
use App\Libs\AppCache;
use App\Traits\Models\IsPriceable;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\CaravanFilter;
use Database\Factories\CaravanFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\Caravan
 *
 * @property int $id
 * @property int $country_id
 * @property string $carnumber
 * @property int $carlength
 * @property string|null $email
 * @property-read \App\Models\Country|null $country
 * @property-read Collection<int, \App\Models\CaravanDates> $dates
 * @property-read int|null $dates_count
 * @property-read mixed $info
 * @property-read mixed $text
 * @method static Builder|Caravan caravan(?int $caravanId = null)
 * @method static Builder|Caravan caravanById(?int $caravanId = null)
 * @method static \Database\Factories\CaravanFactory factory($count = null, $state = [])
 * @method static Builder|Caravan newModelQuery()
 * @method static Builder|Caravan newQuery()
 * @method static Builder|Caravan query()
 * @method static Builder|Caravan sortable($defaultParameters = null)
 * @method static Builder|Caravan whereCarlength($value)
 * @method static Builder|Caravan whereCarnumber($value)
 * @method static Builder|Caravan whereCountryId($value)
 * @method static Builder|Caravan whereEmail($value)
 * @method static Builder|Caravan whereId($value)
 * @mixin Eloquent
 */
class Caravan extends BaseModel
{
    use HasFactory, CaravanFilter, ClearCache, IsPriceable, Sortable;

    protected $table = 'caravans';
    protected $guarded = ['id'];
    protected $appends = ['text','info'];
    public $timestamps = false;
    public $sortable = ['carnumber'];

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_CARAVAN,
        AppCache::KEY_OPTIONS_DATA_CARAVAN,
    ];

    protected $casts = [
        'carlength' => 'integer',
    ];

    public function getTextAttribute()
    {
        return $this->carnumber;
    }

    public function getInfoAttribute()
    {
        if($this->country->code === 'DE' && preg_match("/^[a-z]{1,3}\-/i", $this->carnumber)) {
            list($code,) = explode('-', $this->carnumber);
            return CarLicensePlate::where('code', '=', $code)->get()->first();
        }
        return null;
    }

    public function dates()
    {
        return $this->hasMany(CaravanDates::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}

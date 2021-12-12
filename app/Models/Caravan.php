<?php
namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\HasDailyPrice;
use Eloquent;
use App\Traits\Models\ClearCache;
use App\Traits\Models\Filter\CaravanFilter;
use Database\Factories\CaravanFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Caravan
 *
 * @property int $id
 * @property string $carnumber
 * @property int $carlength
 * @property-read Collection|CaravanDates[] $dates
 * @property-read int|null $dates_count
 * @method static Builder|Caravan newModelQuery()
 * @method static Builder|Caravan newQuery()
 * @method static Builder|Caravan query()
 * @method static Builder|Caravan whereCarlength($value)
 * @method static Builder|Caravan whereCarnumber($value)
 * @method static Builder|Caravan whereId($value)
 * @mixin Eloquent
 * @property string|null $email
 * @method static CaravanFactory factory(...$parameters)
 * @method static Builder|Caravan whereEmail($value)
 * @property int $country_id
 * @property-read Country $country
 * @method static Builder|Caravan whereCountryId($value)
 * @property-read mixed $text
 * @method static Builder|Caravan caravan(?int $caravanId = null)
 * @method static Builder|Caravan caravanByDates(?int $caravanId = null)
 * @property-read mixed $info
 */
class Caravan extends BaseModel
{
    use HasFactory, CaravanFilter, ClearCache;

    protected $table = 'caravans';
    protected $guarded = ['id'];
    protected $appends = ['text','info'];
    public $timestamps = false;

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

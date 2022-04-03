<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Database\Factories\ConfigSaisonRentFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigSaisonRent
 *
 * @property int $id
 * @property string|null $key
 * @property string $name
 * @property-read Collection|ConfigSaisonRentDates[] $dates
 * @property-read int|null $dates_count
 * @method static ConfigSaisonRentFactory factory(...$parameters)
 * @method static Builder|ConfigSaisonRent newModelQuery()
 * @method static Builder|ConfigSaisonRent newQuery()
 * @method static Builder|ConfigSaisonRent query()
 * @method static Builder|ConfigSaisonRent whereId($value)
 * @method static Builder|ConfigSaisonRent whereKey($value)
 * @method static Builder|ConfigSaisonRent whereName($value)
 * @mixin Eloquent
 */
class ConfigSaisonRent extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'config_saison_rents';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_CONFIG_SAISON_RENT,
        AppCache::KEY_OPTIONS_DATA_CONFIG_SAISON_RENT,
    ];

    public function dates()
    {
        return $this->hasMany(ConfigSaisonRentDates::class, 'config_saison_rent_id', 'id');
    }
}

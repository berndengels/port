<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

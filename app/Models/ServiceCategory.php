<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        return $this->belongsTo(PriceType::class);
    }
}

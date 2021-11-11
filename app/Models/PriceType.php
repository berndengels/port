<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

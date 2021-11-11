<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

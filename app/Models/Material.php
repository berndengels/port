<?php

namespace App\Models;

use App\Libs\AppCache;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory, ClearCache;

    protected $table = 'materials';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_MATERIAL,
        AppCache::KEY_OPTIONS_DATA_MATERIAL,
    ];

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class ,'material_category_id', 'id');
    }

    public function priceType()
    {
        return $this->belongsTo(PriceType::class);
    }
}

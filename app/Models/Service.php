<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $guarded = ['id'];
//    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id', 'id');
    }

    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(
            Material::class,
            'service_materials'
//            'service_id',
//            'material_id'
        );
    }
}

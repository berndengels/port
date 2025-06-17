<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigUnitRangeType extends Model
{
    use HasFactory;

    protected $table = 'config_unit_range_types';
    protected $guarded = ['id'];
    public $timestamps = false;

	public function priceComponents()
	{
		return $this->hasMany(ConfigPriceComponent::class, 'config_unit_range_type_id', 'id');
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Houseboat extends Model
{
    use HasFactory;

    protected $table = 'houseboats';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function dates()
    {
        return $this->hasMany(HouseboatDates::class);
    }

    public function model()
    {
        return $this->belongsTo(HouseboatModel::class, 'houseboat_model_id', 'id');
    }
}

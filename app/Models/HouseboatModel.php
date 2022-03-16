<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseboatModel extends Model
{
    use HasFactory;

    protected $table = 'houseboat_models';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function houseboats()
    {
        return $this->hasMany(Houseboat::class);
    }
}

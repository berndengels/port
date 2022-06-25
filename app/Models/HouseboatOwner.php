<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HouseboatOwner extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function houseboats()
    {
        return $this->hasMany(Houseboat::class);
    }
}

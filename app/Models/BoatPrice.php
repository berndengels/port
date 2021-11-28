<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoatPrice extends Model
{
    use HasFactory;

    protected $table = 'boat_prices';
    protected $guarded = ['id'];
    public $timestamps = false;
}

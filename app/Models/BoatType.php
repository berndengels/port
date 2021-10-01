<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoatType extends Model
{
    use HasFactory;

    protected $table = 'boat_types';
    protected $guarded = ['id'];
    public $timestamps = false;
}

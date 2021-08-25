<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaravanDates extends Model
{
    use HasFactory;

    protected $table = 'caravan_dates';
    protected $guarded = [];
    protected $dates = ['from','until'];
    protected $dateFormat = 'Y-m-d';

    public $timestamps = false;
}

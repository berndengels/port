<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarLicensePlate extends Model
{
    use HasFactory;

    protected $table = 'car_license_plates';
    protected $guarded = ['id'];
    public $timestamps = false;

/*
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
*/
}

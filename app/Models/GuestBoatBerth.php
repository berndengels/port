<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBoatBerth extends Model
{
    use HasFactory;

    protected $table = 'guest_boat_berths';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function guestBoatDates()
    {
        return $this->hasMany(GuestBoatDates::class);
    }
}

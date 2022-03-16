<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigSaisonRentDates extends Model
{
    use HasFactory;

    protected $table = 'config_saison_rent_dates';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function saison()
    {
        return $this->belongsTo(ConfigSaisonRent::class, 'config_saison_rent_id', 'id');
    }
}

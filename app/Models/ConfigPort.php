<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPort extends Model
{
    use HasFactory;

    protected $table = 'config_port';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'lat'   => 'float',
        'lng'   => 'float',
    ];
}

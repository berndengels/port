<?php

namespace App\Models;

use App\Traits\Models\UseBooleanIcon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConfigOffer extends Model
{
    use HasFactory, UseBooleanIcon;

    protected $table = 'config_offers';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $casts = [
        'enabled' => 'boolean',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CraneDate extends Model
{
    use HasFactory;

    protected $table = 'crane_dates';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $casts = [
        'crane_data'  => 'datetime',
    ];

    public function cranable()
    {
        return $this->morphTo();
    }
}

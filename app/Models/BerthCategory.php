<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerthCategory extends Model
{
    use HasFactory;

    protected $table = 'berth_categories';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function berths()
    {
        return $this->hasMany(GuestBoatBerth::class);
    }
}

<?php

namespace App\Models;

use App\Models\Filter\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Widget extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'widgets';
    protected $guarded = ['id'];
    public $timestamps = false;

}

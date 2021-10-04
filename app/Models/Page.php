<?php

namespace App\Models;

use App\Models\Filter\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory, HasSlug;

    protected $table = 'pages';
    protected $guarded = ['id'];
    public $timestamps = false;
}

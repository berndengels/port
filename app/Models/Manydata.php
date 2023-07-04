<?php

namespace App\Models;

use Database\Factories\ManydataFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Manydata
 *
 * @method static \Database\Factories\ManydataFactory factory($count = null, $state = [])
 * @method static Builder|Manydata newModelQuery()
 * @method static Builder|Manydata newQuery()
 * @method static Builder|Manydata query()
 * @mixin Eloquent
 */
class Manydata extends Model
{
    use HasFactory;

    protected $table = 'manydata';
    protected $guarded = ['id'];
    public $timestamps = false;
}

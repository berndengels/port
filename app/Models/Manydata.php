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
 * @property int $id
 * @property string $name
 * @property int $test_id
 * @method static ManydataFactory factory(...$parameters)
 * @method static Builder|Manydata newModelQuery()
 * @method static Builder|Manydata newQuery()
 * @method static Builder|Manydata query()
 * @method static Builder|Manydata whereId($value)
 * @method static Builder|Manydata whereName($value)
 * @method static Builder|Manydata whereTestId($value)
 * @mixin Eloquent
 */
class Manydata extends Model
{
    use HasFactory;

    protected $table = 'manydata';
    protected $guarded = ['id'];
    public $timestamps = false;
}

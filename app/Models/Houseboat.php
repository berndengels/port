<?php

namespace App\Models;

use Database\Factories\HouseboatFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Houseboat
 *
 * @property int $id
 * @property int $houseboat_model_id
 * @property string $name
 * @property-read Collection|HouseboatDates[] $dates
 * @property-read int|null $dates_count
 * @property-read HouseboatModel|null $model
 * @method static HouseboatFactory factory(...$parameters)
 * @method static Builder|Houseboat newModelQuery()
 * @method static Builder|Houseboat newQuery()
 * @method static Builder|Houseboat query()
 * @method static Builder|Houseboat whereHouseboatModelId($value)
 * @method static Builder|Houseboat whereId($value)
 * @method static Builder|Houseboat whereName($value)
 * @mixin Eloquent
 */
class Houseboat extends Model
{
    use HasFactory;

    protected $table = 'houseboats';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function dates()
    {
        return $this->hasMany(HouseboatDates::class);
    }

    public function model()
    {
        return $this->belongsTo(HouseboatModel::class, 'houseboat_model_id', 'id');
    }
}

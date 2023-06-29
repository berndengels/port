<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\HouseModel
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $space
 * @property int $floors
 * @property int $sleeping_places
 * @property int|null $peak_season_price
 * @property int|null $mid_season_price
 * @property int|null $low_season_price
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\House[] $houses
 * @property-read int|null $houses_count
 * @method static \Database\Factories\HouseModelFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereFloors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereLowSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereMidSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel wherePeakSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereSleepingPlaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|HouseModel whereSpace($value)
 * @mixin \Eloquent
 */
class HouseModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function houses()
    {
        return $this->hasMany(House::class, 'house_model_id', 'id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->height(150)
            ->format('jpg')
            ->optimize()
        ;

        $this->addMediaConversion('mobile')
            ->width(768)
            ->format('jpg')
            ->optimize()
            ->shouldGenerateResponsiveImages()
        ;

        $this->addMediaConversion('large')
            ->width(2000)
            ->format('jpg')
            ->optimize()
            ->shouldGenerateResponsiveImages()
        ;
    }
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('houseModel');
    }
}

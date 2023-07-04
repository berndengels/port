<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\ApartmentModel
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Apartment> $apartments
 * @property-read int|null $apartments_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Database\Factories\ApartmentModelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereFloors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereLowSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereMidSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel wherePeakSeasonPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereSleepingPlaces($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApartmentModel whereSpace($value)
 * @mixin \Eloquent
 */
class ApartmentModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function apartments()
    {
        return $this->hasMany(Apartment::class, 'apartment_model_id', 'id');
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
        $this->addMediaCollection('apartmentModel');
    }
}

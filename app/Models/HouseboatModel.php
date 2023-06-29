<?php

namespace App\Models;

use Database\Factories\HouseboatModelFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\HouseboatModel
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
 * @property-read Collection|Houseboat[] $houseboats
 * @property-read int|null $houseboats_count
 * @method static HouseboatModelFactory factory(...$parameters)
 * @method static Builder|HouseboatModel newModelQuery()
 * @method static Builder|HouseboatModel newQuery()
 * @method static Builder|HouseboatModel query()
 * @method static Builder|HouseboatModel whereDescription($value)
 * @method static Builder|HouseboatModel whereFloors($value)
 * @method static Builder|HouseboatModel whereId($value)
 * @method static Builder|HouseboatModel whereLowSeasonPrice($value)
 * @method static Builder|HouseboatModel whereMidSeasonPrice($value)
 * @method static Builder|HouseboatModel whereName($value)
 * @method static Builder|HouseboatModel wherePeakSeasonPrice($value)
 * @method static Builder|HouseboatModel whereSleepingPlaces($value)
 * @method static Builder|HouseboatModel whereSpace($value)
 * @mixin Eloquent
 */
class HouseboatModel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'houseboat_models';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function houseboats()
    {
        return $this->hasMany(Houseboat::class, 'houseboat_model_id', 'id');
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
        $this->addMediaCollection('houseboatModel');
    }
}

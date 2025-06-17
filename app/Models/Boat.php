<?php
namespace App\Models;

use Database\Factories\BoatFactory;
use Eloquent;
use App\Libs\AppCache;
use App\Traits\Models\IsPriceable;
use App\Libs\Calculations\Boat\Area;
use App\Traits\Models\ClearCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * App\Models\Boat
 *
 * @property int $id
 * @property int|null $berth_id
 * @property int $customer_id
 * @property string $type
 * @property string $name
 * @property string|null $length
 * @property string|null $width
 * @property int|null $weight
 * @property int|null $board_height
 * @property int|null $mast_length
 * @property int|null $mast_weight
 * @property string|null $draft
 * @property string|null $length_waterline
 * @property string|null $length_keel
 * @property string|null $home_port
 * @property-read Berth|null $berth
 * @property-read Collection<int, CraneDate> $craneDates
 * @property-read int|null $crane_dates_count
 * @property-read Customer $customer
 * @property-read Collection<int, BoatDates> $dates
 * @property-read int|null $dates_count
 * @property-read mixed $board_area
 * @property-read mixed $underwater_area
 * @property-read MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read Collection<int, ConfigBoatPrice> $prices
 * @property-read int|null $prices_count
 * @property-read Collection<int, ServiceRequest> $serviceRequests
 * @property-read int|null $service_requests_count
 * @method static BoatFactory factory($count = null, $state = [])
 * @method static Builder|Boat newModelQuery()
 * @method static Builder|Boat newQuery()
 * @method static Builder|Boat query()
 * @method static Builder|Boat sortable($defaultParameters = null)
 * @method static Builder|Boat whereBerthId($value)
 * @method static Builder|Boat whereBoardHeight($value)
 * @method static Builder|Boat whereCustomerId($value)
 * @method static Builder|Boat whereDraft($value)
 * @method static Builder|Boat whereHomePort($value)
 * @method static Builder|Boat whereId($value)
 * @method static Builder|Boat whereLength($value)
 * @method static Builder|Boat whereLengthKeel($value)
 * @method static Builder|Boat whereLengthWaterline($value)
 * @method static Builder|Boat whereMastLength($value)
 * @method static Builder|Boat whereMastWeight($value)
 * @method static Builder|Boat whereName($value)
 * @method static Builder|Boat whereType($value)
 * @method static Builder|Boat whereWeight($value)
 * @method static Builder|Boat whereWidth($value)
 * @mixin Eloquent
 */
class Boat extends Model implements HasMedia
{
    use HasFactory, ClearCache, IsPriceable, Sortable, InteractsWithMedia;

    protected $table = 'boats';
    protected $with = 'customer';
    protected $guarded = ['id'];
    protected $appends = ['underwaterArea', 'boardArea'];
    public $timestamps = false;
    public $sortable = ['name','type','customer.name'];

    /**
     * @var Area
     */
    protected $calculator;

    protected static $cacheKeys = [
        AppCache::KEY_OPTIONS_BOAT,
        AppCache::KEY_OPTIONS_DATA_BOAT,
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function berth()
    {
        return $this->belongsTo(Berth::class);
    }

    public function dates()
    {
        return $this->hasMany(BoatDates::class);
    }

    public function craneDates()
    {
        return $this->morphMany(CraneDate::class, 'cranable');
    }

    public function prices()
    {
        return $this->hasMany(ConfigBoatPrice::class);
    }

    public function serviceRequests()
    {
        if($this->hasOne(Customer::class)) {
            return $this->hasMany(ServiceRequest::class, 'boat_id', 'id');
        }
//        return null;
    }

    protected function area(): Area
    {
        $area = new Area(
            boatType: $this->type,
            length: $this->length,
            lengthWaterline: $this->length_waterline,
            lengthKeel: $this->length_keel,
            width: $this->width,
            draft: $this->draft,
            boardHeight: $this->board_height
        );
        return $area;
    }

    public function getBoardAreaAttribute()
    {
        return $this->area()->getBoardArea();
    }

    public function getUnderwaterAreaAttribute()
    {
        return $this->area()->getUnderwaterArea();
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
		$this->addMediaCollection('boat');
	}
}

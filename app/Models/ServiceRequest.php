<?php

namespace App\Models;

use Eloquent;
use Carbon\Carbon;
use App\Events\ServiceRequested;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ServiceRequestFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\ServiceRequest
 *
 * @property int $id
 * @property int $boat_id
 * @property string $description
 * @property bool|null $done
 * @property \Illuminate\Support\Carbon|null $done_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Boat $boat
 * @property-read Collection|Service[] $services
 * @property-read int|null $services_count
 * @method static ServiceRequestFactory factory(...$parameters)
 * @method static Builder|ServiceRequest newModelQuery()
 * @method static Builder|ServiceRequest newQuery()
 * @method static Builder|ServiceRequest query()
 * @method static Builder|ServiceRequest whereBoatId($value)
 * @method static Builder|ServiceRequest whereCreatedAt($value)
 * @method static Builder|ServiceRequest whereDescription($value)
 * @method static Builder|ServiceRequest whereDone($value)
 * @method static Builder|ServiceRequest whereDoneAt($value)
 * @method static Builder|ServiceRequest whereId($value)
 * @method static Builder|ServiceRequest whereUpdatedAt($value)
 * @mixin Eloquent
 * @property mixed $done_until
 * @method static Builder|ServiceRequest whereDoneUntil($value)
 */
class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'service_requests';
    protected $with = 'boat';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'done_at', 'done_until'];
    protected $casts = [
        'done' => 'boolean',
        'done_until' => 'date:Y-m-d',
    ];
//    public $timestamps = false;

    protected static function booted()
    {
        static::created(function (ServiceRequest $serviceRequest) {
            event(new ServiceRequested($serviceRequest->refresh(), 'store'));
        });
        static::updated(function (ServiceRequest $serviceRequest) {
            event(new ServiceRequested($serviceRequest->refresh(), 'update'));
        });
    }

    public function setDoneAttribute(bool $value) {
        $this->attributes['done'] = $value;
        $this->attributes['done_at'] = $value ? Carbon::now()->format('Y-m-d H:i:s') : null;
    }

    public function boat()
    {
        return $this->belongsTo(Boat::class, 'boat_id', 'id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'service_requests_services'
        );
    }

    public function totalPrice(): int|float
    {
        $total = $this->services->sum(function (Service $service) {
            $servicePrice = $service->getServicePrice($this->boat);
            return $servicePrice + $service->materials->sum(function(Material $material) use($servicePrice) {
                return $material->getMaterialPrice($this->boat);
            });
        });

        return $total;
    }
}

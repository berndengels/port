<?php

namespace App\Models;

use App\Libs\Prices\PriceCalculator;
use Eloquent;
use Carbon\Carbon;
use App\Traits\Models\HasPrice;
use App\Traits\Models\UseBooleanIcon;
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
 * @property \Illuminate\Support\Carbon $done_until
 * @property bool|null $done
 * @property string|null $done_at
 * @property bool|null $is_paid
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Boat $boat
 * @property-read mixed $price_data
 * @property-read Collection<int, \App\Models\Service> $services
 * @property-read int|null $services_count
 * @method static \Database\Factories\ServiceRequestFactory factory($count = null, $state = [])
 * @method static Builder|ServiceRequest newModelQuery()
 * @method static Builder|ServiceRequest newQuery()
 * @method static Builder|ServiceRequest query()
 * @method static Builder|ServiceRequest whereBoatId($value)
 * @method static Builder|ServiceRequest whereCreatedAt($value)
 * @method static Builder|ServiceRequest whereDescription($value)
 * @method static Builder|ServiceRequest whereDone($value)
 * @method static Builder|ServiceRequest whereDoneAt($value)
 * @method static Builder|ServiceRequest whereDoneUntil($value)
 * @method static Builder|ServiceRequest whereId($value)
 * @method static Builder|ServiceRequest whereIsPaid($value)
 * @method static Builder|ServiceRequest whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ServiceRequest extends Model
{
    use HasFactory,
        HasPrice,
        UseBooleanIcon;

    protected $table = 'service_requests';
    protected $with = 'boat';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'done_at', 'done_until'];
    protected $casts = [
        'done'      => 'bool',
        'is_paid'   => 'bool',
        'done_until' => 'date:Y-m-d',
    ];
//    public $timestamps = false;

    protected static function booted()
    {
        static::created(function (ServiceRequest $serviceRequest) {
            $serviceRequest->refresh();
            event(new ServiceRequested($serviceRequest, 'store'));
        });
        static::updated(function (ServiceRequest $serviceRequest) {
            $serviceRequest->refresh();
            event(new ServiceRequested($serviceRequest, 'update'));
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

    public function nettoPrice(): int|float|null
    {
        $total = $this->totalPrice();
        return PriceCalculator::nettoPrice($total);
    }
}

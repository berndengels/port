<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ServiceRequestFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'done_at', 'done_until'];
    protected $casts = [
        'done' => 'boolean',
        'done_until' => 'date:Y-m-d',
    ];
//    public $timestamps = false;

    public function setDoneAttribute(bool $value) {
        $this->attributes['done'] = $value;
        if($value) {
            $this->attributes['done_at'] = Carbon::now()->format('Y-m-d H:i:s');
        }
    }

    public function boat()
    {
        return $this->belongsTo(Boat::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'service_requests_services'
        );
    }

    public function totalPrice(int|float $targetValue, int $roundPrecision = 2 ): int|float
    {
        $total = $this->services->sum(function (Service $service) use ($targetValue) {
            $servicePrice = $service->getServicePrice($targetValue);
            return $servicePrice + $service->materials->sum(function(Material $material) use($servicePrice, $targetValue) {
                return $material->getMaterialPrice($targetValue);
            });
        });
        return round($total, $roundPrecision);
    }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'service_requests';
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'done_at'];
//    public $timestamps = false;

    public function setDoneAttribute($value = null) {
        if($value) {
//            $this->done_at = Carbon::create()->format('Y-m-d H:i:s');
            $this->done_at = Carbon::create();
        }
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'service_requests_services'
        );
    }
}

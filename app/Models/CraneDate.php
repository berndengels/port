<?php

namespace App\Models;

use App\Traits\Models\HasCustomer;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\CraneDate
 *
 * @property int $id
 * @property string $cranable_type
 * @property int $cranable_id
 * @property Carbon|null $date
 * @property Carbon $crane_date
 * @property string|null $crane_time
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property-read Model|Eloquent $cranable
 * @method static Builder|CraneDate newModelQuery()
 * @method static Builder|CraneDate newQuery()
 * @method static Builder|CraneDate query()
 * @method static Builder|CraneDate whereCranableId($value)
 * @method static Builder|CraneDate whereCranableType($value)
 * @method static Builder|CraneDate whereCraneDate($value)
 * @method static Builder|CraneDate whereCraneTime($value)
 * @method static Builder|CraneDate whereCreatedBy($value)
 * @method static Builder|CraneDate whereDate($value)
 * @method static Builder|CraneDate whereId($value)
 * @method static Builder|CraneDate whereUpdatedBy($value)
 * @mixin Eloquent
 */
class CraneDate extends Model
{
    use HasFactory, HasCustomer;

    protected $table = 'crane_dates';
    protected $guarded = ['id'];
    public $timestamps = false;
    protected $casts = [
		'date' => 'datetime:Y-m-d H.i',
        'crane_date' => 'date:d.m.Y',
    ];

    public function cranable()
    {
        return $this->morphTo();
    }

	public function customer()
	{
		return app($this->cranable_type)::find($this->cranable_id)->first()->customer;
	}
}

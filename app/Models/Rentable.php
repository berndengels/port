<?php

namespace App\Models;

use App\Traits\Models\Filter\RentableFilter;
use App\Traits\Models\HasPrice;
use App\Traits\Models\Filter\HasYearMonthOptions;
use App\Traits\Models\Filter\YearMonthFilter;
use App\Traits\Models\HasFromUntilDates;
use App\Traits\Models\UseBooleanIcon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Kyslik\ColumnSortable\Sortable;

/**
 * App\Models\Rentable
 *
 * @property int $id
 * @property int $rentable_id
 * @property string|null $rentable_type
 * @property int $customer_id
 * @property \Illuminate\Support\Carbon $from
 * @property \Illuminate\Support\Carbon $until
 * @property int|null $price
 * @property string|null $prices
 * @property bool $is_paid
 * @property-read \App\Models\Customer $customer
 * @property-read mixed $days
 * @property-read mixed $has_kilowatt
 * @property-read mixed $has_rental_cleaning
 * @property-read mixed $kilowatt
 * @property-read mixed $price_data
 * @property-read mixed $rental_cleaning
 * @property-read mixed $valid_from
 * @property-read mixed $valid_until
 * @property-read Model|\Eloquent $rentable
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable datesBetween(?\Carbon\Carbon $from = null, ?\Carbon\Carbon $until = null)
 * @method static \Database\Factories\RentableFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable fromYearMonth(?string $year = null, ?string $month = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable relation(array|string $rentableType, ?int $rentableId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable whereIsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable wherePrices($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable whereRentableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable whereRentableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rentable whereUntil($value)
 * @mixin \Eloquent
 */
class Rentable extends Model
{
    use HasFactory,
        HasYearMonthOptions,
        HasFromUntilDates,
        UseBooleanIcon,
        YearMonthFilter,
        RentableFilter,
        HasPrice,
        Sortable;

    protected $guarded = ['id'];
    public $timestamps = false;

    protected $with = ['rentable'];
    protected $dates = ['from', 'until'];
    protected $appends = [
        'kilowatt',
        'rentalCleaning',
        'hasKilowatt',
        'hasRentalCleaning',
    ];
    protected $casts = [
        'from'      => 'date:Y-m-d',
        'until'     => 'date:Y-m-d',
        'is_paid'   => 'bool',
    ];
    public $sortable = ['from','is_paid'];

    public function rentable()
    {
        return $this->morphTo();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getHasKilowattAttribute()
    {
        return (isset($this->priceData->kilowatt) && $this->priceData->kilowatt > 0) ? true : false;
    }

    public function getKilowattAttribute()
    {
        return $this->priceData->kilowatt ?? null;
    }

    public function getHasRentalCleaningAttribute()
    {
        return (isset($this->priceData->rental_cleaning) && $this->priceData->rental_cleaning > 0) ? true : false;
    }

    public function getRentalCleaningAttribute()
    {
        return $this->priceData->rental_cleaning ?? null;
    }
}

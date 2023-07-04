<?php

namespace App\Models;

use Database\Factories\HouseboatOwnerFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\HouseboatOwner
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $city
 * @property string $postcode
 * @property string $street
 * @property string $fon
 * @property string $bank
 * @property string $iban
 * @property string $bic
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, \App\Models\Houseboat> $houseboats
 * @property-read int|null $houseboats_count
 * @method static \Database\Factories\HouseboatOwnerFactory factory($count = null, $state = [])
 * @method static Builder|HouseboatOwner newModelQuery()
 * @method static Builder|HouseboatOwner newQuery()
 * @method static Builder|HouseboatOwner query()
 * @method static Builder|HouseboatOwner whereBank($value)
 * @method static Builder|HouseboatOwner whereBic($value)
 * @method static Builder|HouseboatOwner whereCity($value)
 * @method static Builder|HouseboatOwner whereCreatedAt($value)
 * @method static Builder|HouseboatOwner whereEmail($value)
 * @method static Builder|HouseboatOwner whereFon($value)
 * @method static Builder|HouseboatOwner whereIban($value)
 * @method static Builder|HouseboatOwner whereId($value)
 * @method static Builder|HouseboatOwner whereName($value)
 * @method static Builder|HouseboatOwner wherePostcode($value)
 * @method static Builder|HouseboatOwner whereStreet($value)
 * @method static Builder|HouseboatOwner whereUpdatedAt($value)
 * @mixin Eloquent
 */
class HouseboatOwner extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function houseboats()
    {
        return $this->hasMany(Houseboat::class);
    }
}

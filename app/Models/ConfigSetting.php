<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\ConfigSettingsFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ConfigPort
 *
 * @property int $id
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property string $street
 * @property string $location
 * @property string $postcode
 * @property string|null $email
 * @property string|null $fon
 * @property string|null $bank
 * @property string|null $bic
 * @property string|null $iban
 * @property float $tax
 * @property bool $use_tax
 * @method static Builder|ConfigSetting newModelQuery()
 * @method static Builder|ConfigSetting newQuery()
 * @method static Builder|ConfigSetting query()
 * @method static Builder|ConfigSetting whereBank($value)
 * @method static Builder|ConfigSetting whereBic($value)
 * @method static Builder|ConfigSetting whereEmail($value)
 * @method static Builder|ConfigSetting whereFon($value)
 * @method static Builder|ConfigSetting whereIban($value)
 * @method static Builder|ConfigSetting whereId($value)
 * @method static Builder|ConfigSetting whereLat($value)
 * @method static Builder|ConfigSetting whereLng($value)
 * @method static Builder|ConfigSetting whereLocation($value)
 * @method static Builder|ConfigSetting whereName($value)
 * @method static Builder|ConfigSetting wherePostcode($value)
 * @method static Builder|ConfigSetting whereStreet($value)
 * @method static Builder|ConfigSetting whereTax($value)
 * @method static Builder|ConfigSetting whereUseTax($value)
 * @mixin Eloquent
 */
class ConfigSetting extends Model
{
    use HasFactory;

    protected $table = 'config_settings';
    protected $guarded = ['id'];
    public $timestamps = false;

    protected $casts = [
        'lat'   => 'float',
        'lng'   => 'float',
        'use_tax'   => 'bool',
        'tax'   => 'float',
    ];
}

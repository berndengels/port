<?php
namespace Database\Seeders;

use App\Models\CarLicensePlate;
use Database\Data\CarLicensePlateData;
use Database\Seeders\Ext\MainTestSeeder;

class CarLicensePlateTestSeeder extends MainTestSeeder
{
    protected $table = 'car_license_plates';
    protected $model = CarLicensePlate::class;
    protected $dataClass = CarLicensePlateData::class;
}

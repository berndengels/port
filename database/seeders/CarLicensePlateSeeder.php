<?php
namespace Database\Seeders;

use Database\Data\CarLicensePlateData;
use Database\Seeders\Ext\MainTestSeeder;

class CarLicensePlateSeeder extends MainTestSeeder
{
    protected $truncate = true;
    protected $table = 'car_license_plates';
    protected $dataClass = CarLicensePlateData::class;
}

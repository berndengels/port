<?php

namespace App\Exports;

use App\Models\CaravanDates;

class CaravanDatesExport extends FromViewExport
{
    protected $view  = 'admin.caravanDates.export';
    protected $model = CaravanDates::class;
    protected $with = 'caravan';
}

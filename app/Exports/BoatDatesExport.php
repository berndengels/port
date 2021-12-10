<?php

namespace App\Exports;

use App\Models\BoatDates;

class BoatDatesExport extends FromViewExport
{
    protected $view  = 'admin.boatDates.export';
    protected $model = BoatDates::class;
    protected $with = 'boat';
}

<?php

namespace App\Exports;

use App\Models\GuestBoatDates;

class GuestBoatDatesExport extends FromViewExport
{
    protected $view  = 'admin.guestBoatDates.export';
    protected $model = GuestBoatDates::class;
    protected $with = 'boat';
}

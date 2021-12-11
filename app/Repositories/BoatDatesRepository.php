<?php

namespace App\Repositories;

use App\Models\BoatDates;
use App\Models\ConfigSaisonDates;

class BoatDatesRepository extends StatsRepository
{
    protected static $model = BoatDates::class;
}

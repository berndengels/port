<?php

namespace App\Libs\Vendor\LaravelCalendar\Facades;

use Illuminate\Support\Facades\Facade;

class Calendar extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-calendar';
    }
}

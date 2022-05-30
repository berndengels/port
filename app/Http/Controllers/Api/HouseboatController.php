<?php

namespace App\Http\Controllers\Api;

use App\Models\HouseboatDates;
use App\Http\Controllers\Controller;
use App\Repositories\CalendarRepository;

class HouseboatController extends Controller
{
    public function index() {

        $data = HouseboatDates::orderBy('from')->get();
        $dates = (new CalendarRepository('houseboat', $data))->getDates()->toArray();
        return response()->json($dates);
    }
}

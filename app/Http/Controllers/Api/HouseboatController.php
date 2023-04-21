<?php

namespace App\Http\Controllers\Api;

use App\Models\HouseboatRentals;
use App\Http\Controllers\Controller;
use App\Repositories\CalendarRepository;
use Carbon\Carbon;

class HouseboatController extends Controller
{
    public function index() {
        $data = HouseboatRentals::with(['houseboat','customer'])->orderBy('from')->get();
        $dates = (new CalendarRepository('houseboat', $data))->getDates()->toArray();
        return response()->json($dates);
    }

    public function reservations() {
        $today = Carbon::today()->format('Y-m-d');
        $data = HouseboatRentals::with(['houseboat'])->whereDate('from','>=', $today)->orderBy('from')->get();
        $dates = (new CalendarRepository('houseboat', $data))->getReservationDates();
        return response()->json($dates);
    }
}

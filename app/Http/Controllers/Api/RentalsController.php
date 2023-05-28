<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Rentable;
use App\Repositories\CalendarRentableRepository;
use App\Http\Controllers\RentableController;

class RentalsController extends RentableController
{
    public function index() {
        $data = Rentable::with(['customer'])
            ->whereHasMorph('rentable', $this->configOffers)
            ->orderBy('from')
            ->get()
        ;

        if(!$data->count()) {
            return response()->json(['error' => 'no data'], 204);
        }

        $dates = (new CalendarRentableRepository($data))->getDates()->toArray();
        return response()->json($dates);
    }

    public function reservations() {
        $today = Carbon::today()->format('Y-m-d');
        $data = Rentable::whereDate('until','>=', $today)
            ->whereHasMorph('rentable', $this->configOffers)
            ->orderBy('from')
            ->get();

        if(!$data->count()) {
            return response()->json(['error' => 'no data'], 204);
        }

        $response = (new CalendarRentableRepository($data))->getReservationDates(withUrl: false);

        return response()->json($response);
    }
}

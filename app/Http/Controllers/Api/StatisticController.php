<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\BoatDatesRepository;
use App\Repositories\CaravanDatesRepository;
use App\Repositories\RentableRepository;
use App\Repositories\GuestBoatDatesRepository;
use Illuminate\Support\Facades\Config;

class StatisticController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function caravans()
    {
        $data = config('port.menu.admin.items.Caravans') ? CaravanDatesRepository::getVisits() : null;
        if(!$data) {
            return response()->json(['error' => 'no data'], 204);
        }
        return response()->json($data);
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function guestBoats()
    {
        $data = config('port.menu.admin.items.Boote') ? GuestBoatDatesRepository::getVisits() : null;
        if(!$data) {
            return response()->json(['error' => 'no data'], 204);
        }
        return response()->json($data);
    }
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function boats()
    {
        $data = config('port.menu.admin.items.Boote') ? BoatDatesRepository::getVisits() : null;
        if(!$data) {
            return response()->json(['error' => 'no data'], 204);
        }
        return response()->json($data);
    }

    public function rentals()
    {
        $enabled = config('offers.Häuser') || config('offers.Hausboote') || config('offers.Apartments');
        $data = $enabled ? RentableRepository::getVisits() : null;
        if(!$data) {
            return response()->json(['error' => 'no data'], 204);
        }
        return response()->json($data);
    }

    public function rentalSalesVolumes()
    {
        $enabled = config('offers.Häuser') || config('offers.Hausboote') || config('offers.Apartments');
        $data = $enabled ? RentableRepository::getRentalSalesVolume() : null;
        if(!$data) {
            return response()->json(['error' => 'no data'], 204);
        }
        return response()->json($data);
    }
}

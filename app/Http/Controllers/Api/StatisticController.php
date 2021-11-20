<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\BoatDatesRepository;
use App\Repositories\CaravanDatesRepository;
use App\Repositories\GuestBoatDatesRepository;

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
        $data = CaravanDatesRepository::getVisits();
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
        $data = GuestBoatDatesRepository::getVisits();
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
        $data = BoatDatesRepository::getVisits();
        return response()->json($data);
    }

}

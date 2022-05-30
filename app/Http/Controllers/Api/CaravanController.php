<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CaravanRequest;
use App\Models\Caravan;
use Carbon\Carbon;

class CaravanController extends Controller
{
    public function todayVisits() {
        $today = Carbon::today()->format('Y-m-d');
        $data = CaravanDates::with('caravan')
            ->whereRaw('DATE(?) BETWEEN `from` AND `until`', [$today])
            ->get();
        if($data->count() > 0) {
            $data = $data->map(
                function ($item) {
                    return $item->caravan->carnumber;
                }
            )->sort();
        }

        return response()->json($data);
    }

    public function store(CaravanRequest $request) {

        return response()->json(Caravan::create($request->validated()));
    }
}

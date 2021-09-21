<?php

namespace App\Http\Controllers;

use App\Models\Caravan;
use App\Models\CaravanDates;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $caravansFromToday;

    public function __construct()
    {
        $today = Carbon::today()->format('Y-m-d');
        $data = CaravanDates::with('caravan')
            ->whereRaw('DATE(?) BETWEEN `from` AND `until`', [$today])
            ->get()
        ;
        if($data->count() > 0) {
            $this->caravansFromToday = $data->map(function($item) {
                return $item->caravan->carnumber;
            })->sort();
        }
    }

    public function show() {
        return view('admin.dashboard', [
            'map'   => config('port.map'),
            'caravansFromToday' => $this->caravansFromToday,
        ]);
    }
}

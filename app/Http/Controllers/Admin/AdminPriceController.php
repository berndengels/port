<?php
namespace App\Http\Controllers\Admin;

use App\Libs\BoatPriceCalculator;
use App\Libs\Prices\BoatGuestPrice;
use App\Libs\Prices\BoatPrice;
use App\Libs\Prices\CaravanPrice;
use App\Models\Boat;
use App\Models\BoatGuest;
use Excel;
use Carbon\Carbon;
use App\Models\CaravanDates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Libs\CaravanPriceCalculator;
use App\Exports\CaravanDatesExport;

class AdminPriceController extends AdminController
{
    /**
     * Calculate caravan price.
     *
     * @param Request $request
     * @return Response
     */
    public function calculateCaravanDates(Request $request)
    {
        $carlength  = $request->post('carlength');
        $from       = $request->post('from');
        $until      = $request->post('until');
        $persons    = (int) $request->post('persons');
        $response   = ['error' => true];

        if($from && $until && $carlength && $persons) {
            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));
            $response   = (new CaravanPrice($from, $until))->getPrice($request);
        }
        return response()->json($response);
    }

    /**
     * Calculate boat dates price.
     *
     * @param Request $request
     * @return Response
     */
    public function calculateBoatDates(Request $request)
    {
        $boatId     = $request->post('boat_id');
        $from       = $request->post('from');
        $until      = $request->post('until');
        $boat       = Boat::find($boatId);
        $response   = ['error' => true];

        if($boat && $from && $until) {
            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));
            $response   = (new BoatPrice($from, $until))->getPrice($request);
        }

        return response()->json($response);
    }

    /**
     * Calculate boat dates price.
     *
     * @param Request $request
     * @return Response
     */
    public function calculateGuestBoatDates(Request $request)
    {
        $from       = $request->post('from');
        $until      = $request->post('until');
        $length     = $request->post('length');
        $response   = ['error' => true];

        if($from && $until && $length) {
            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));
            $response   = (new BoatGuestPrice($from, $until))->getPrice($request);
        }

        return response()->json($response);
    }

    public function excel($year = null, $month = null)
    {
        $now = Carbon::now()->format('Ymd-Hi');
        $export = new CaravanDatesExport($year, $month);
        return Excel::download($export, $now.'_caravan_dates.xlsx');
    }

    public function pdf(Carbon $from)
    {
        $data = CaravanDates::with('caravan')
            ->whereDate('from','>=', $from)
            ->orderBy('from')
            ->get()
        ;
    }
}

<?php
namespace App\Http\Controllers\Admin;

use App\Libs\BoatPriceCalculator;
use App\Libs\Prices\GuestBoatPrice;
use App\Libs\Prices\BoatPrice;
use App\Libs\Prices\CaravanPrice;
use App\Models\Boat;
use App\Models\GuestBoat;
use App\Models\Caravan;
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
     * @param  Request $request
     * @return Response
     */
    public function calculateCaravanDates(Request $request)
    {
        $carnumber  = $request->post('carnumber');
        $carlength  = $request->post('carlength');
        $from       = $request->post('from');
        $until      = $request->post('until');
        $response   = ['error' => true];
        $caravan    = Caravan::whereCarnumber($carnumber)->first();

        if($from && $until && $carlength) {
            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));
            $response   = (new CaravanPrice($from, $until, $caravan))->getPrice($request);
        }
        return response()->json($response);
    }

    /**
     * Calculate boat dates price.
     *
     * @param  Request $request
     * @return Response
     */
    public function calculateBoatDates(Request $request)
    {
        $boatId     = $request->post('boat_id');
        $from       = $request->post('from');
        $until      = $request->post('until');
        $boat       = Boat::find($boatId);
        $response   = ['error' => true];

        if($boat) {
            $from       = $from ? new Carbon($from, config('app.timezone')) : null;
            $until      = $until ? new Carbon($until, config('app.timezone')) : null;
            $response   = (new BoatPrice($from, $until, $boat))->getPrice($request);
        }

        return response()->json($response);
    }

    /**
     * Calculate boat dates price.
     *
     * @param  Request $request
     * @return Response
     */
    public function calculateGuestBoatDates(Request $request)
    {
        $name       = $request->post('name');
        $from       = $request->post('from');
        $until      = $request->post('until');
        $length     = $request->post('length');
        $response   = ['error' => true];
        $guestBoat  = GuestBoat::whereName($name)->whereLength($length)->first();

        if($from && $until && $length) {
            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));
            $response   = (new GuestBoatPrice($from, $until, $guestBoat))->getPrice($request);
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
            ->whereDate('from', '>=', $from)
            ->orderBy('from')
            ->get();
    }
}

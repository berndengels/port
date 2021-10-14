<?php
namespace App\Http\Controllers\Admin;

use App\Libs\BoatCalculator;
use App\Models\Boat;
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
        $electric   = (bool) $request->post('electric');
        $dayPrice   = !empty($request->post('day_price')) ? (int) $request->post('day_price') : null;
        $response   = null;

        if($from && $until && $carlength && $persons) {
            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));
            $response   = (new CaravanPriceCalculator)->getPrice($from, $until, $carlength, $persons, $electric, $dayPrice);
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
        $modus      = $request->post('modus');
        $boat       = Boat::find($boatId);
        $response = ['error' => true];

        if($boat) {
            $length     = $boat->length;
            $width      = $boat->width;
            $weight     = $boat->weight;
            $mastLength = $boat->mast_length;
            $mastWeight = $boat->mast_weight;
            $from       = $request->post('from');
            $until      = $request->post('until');
            $defaultPrice = $request->post('default_price');

            $crane      = (bool) $request->post('crane', false);
            $mastCrane  = (bool) $request->post('mast_crane', false);
            $cleaning   = (bool) $request->post('cleaning', false);

            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));

            $response   = (new BoatCalculator())->getPrice($modus, $length, $width, $weight, $mastLength, $mastWeight, $crane, $mastCrane, $cleaning, $from, $until, $defaultPrice);
        }

        return response()->json($response);
    }

    public function getBilling(CarabanDates $caravanDate)
    {
    }

    public function excel($year = null, $month = nll)
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

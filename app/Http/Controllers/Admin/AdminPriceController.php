<?php
namespace App\Http\Controllers\Admin;

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
     * Calculate price.
     *
     * @param Request $request
     * @return Response
     */
    public function calculate(Request $request)
    {
        $carlength  = $request->post('carlength');
        $from       = $request->post('from');
        $until      = $request->post('until');
        $persons    = (int) $request->post('persons');
        $electric   = (bool) $request->post('electric');
        $dayPrice   = (int) $request->post('day_price');
        $response   = null;

        if($from && $until && $carlength && $persons) {
            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));
            $response   = CaravanPriceCalculator::getPrice($from, $until, $carlength, $persons, $electric, $dayPrice);
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

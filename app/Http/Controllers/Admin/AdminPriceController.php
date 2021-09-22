<?php
namespace App\Http\Controllers;

use App\Exports\CaravanDatesExport;
use App\Models\CaravanDates;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Libs\CaravanPriceCalculator;
use Excel;

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

        $response = null;

        if($from && $until && $carlength && $persons) {
            $from   = new Carbon($from, config('app.timezone'));
            $until  = new Carbon($until, config('app.timezone'));

            $response =  CaravanPriceCalculator::getPrice($from, $until, $carlength, $persons, $electric);
        }
        return response()->json($response);
    }

    public function getBilling(CarabanDates $caravanDate)
    {
    }

    public function excel($from = null)
    {
        $now = Carbon::now()->format('Ymd-Hi');
        $export = new CaravanDatesExport($from);
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

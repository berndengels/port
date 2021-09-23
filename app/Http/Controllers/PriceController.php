<?php
namespace App\Http\Controllers;

use App\Exports\CaravanDatesExport;
use App\Models\CaravanDates;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Libs\CaravanPriceCalculator;
//use Maatwebsite\Excel\Facades\Excel;
use Excel;

class PriceController extends Controller
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

    public function excel($year = null, $month = null)
    {
        $now = Carbon::now()->format('Ymd-Hi');
        $export = new CaravanDatesExport($year, $month);
        return Excel::download($export, $now.'_caravan_dates.xlsx');
    }

    public function pdf($year = null, $month = null)
    {
        $query = CaravanDates::with('caravan');

        if($year) {
            $query->whereRaw('YEAR(`from`) = ?', [$year]);
            if($month) {
                $query->whereRaw('YEAR(`from`) = ? AND MONTH(`from`) = ?', [$year, $month]);
            }
        }

        $data = $query->orderBy('from')->get();
        // @todo: generate pdf  by html view
    }
}

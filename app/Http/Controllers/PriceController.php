<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Libs\CaravanPriceCalculator;

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
}

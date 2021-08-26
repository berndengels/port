<?php
namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Libs\CaravanPriceCalculator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class PriceController extends Controller
{
    private $calculator;

    public function __construct()
    {
        $this->calculator = new CaravanPriceCalculator();
    }

    /**
     * Calculate price.
     *
     * @param Request $request
     * @return Response
     */
    public function calculate(Request $request)
    {
        $from       = $request->post('from');
        $until      = $request->post('until');
        $persons    = (int) $request->post('persons');
        $electric   = (bool) $request->post('electric');
        $response = ['price'    => null];

        if($from && $until && $persons) {
            $from   = new Carbon($from, config('app.timezone'));
            $until  = new Carbon($until, config('app.timezone'));

            $response = ['price' => $this->calculator->getPrice($from, $until, $persons, $electric)];
        }

        return response()->json($response);
    }
}

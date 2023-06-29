<?php
namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Boat;
use App\Models\BoatDates;
use App\Models\GuestBoat;
use App\Models\Caravan;
use App\Exports\BoatDatesExport;
use App\Exports\GuestBoatDatesExport;
use App\Exports\HouseBoatDatesExport;
use App\Exports\RentalsExport;
use App\Libs\BoatPriceCalculator;
use App\Libs\Prices\GuestBoatPrice;
use App\Libs\Prices\BoatPrice;
use App\Libs\Prices\CaravanPrice;
use App\Libs\Prices\HouseboatPrice;
use App\Libs\Prices\RentablePrice;
use App\Models\GuestBoatDates;
use App\Models\HouseboatRentals;
use App\Models\Rentable;
use App\Models\CaravanDates;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Libs\CaravanPriceCalculator;
use App\Exports\CaravanDatesExport;
use Maatwebsite\Excel\Excel;

class AdminPriceController extends AdminController
{
    /**
     * Calculate caravan price.
     *
     * @param  Request $request
     * @return Response
     */
    public function calculateCaravanPrices(Request $request)
    {
        $carnumber  = $request->post('carnumber');
        $carlength  = $request->post('carlength');
        $from       = $request->post('from');
        $until      = $request->post('until');
        $persons    = $request->post('persons');
        $response   = ['error' => true];
        $caravan    = Caravan::whereCarnumber($carnumber)->first();

        if($from && $until && $carlength && $persons) {
            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));
            $response   = (new CaravanPrice($caravan, $from, $until))->getPrice($request);
        }
        return response()->json($response);
    }

    /**
     * Calculate boat dates price.
     *
     * @param  Request $request
     * @return Response
     */
    public function calculateBoatPrices(Request $request)
    {
        $boatId     = $request->post('boat_id');
        $from       = $request->post('from');
        $until      = $request->post('until');
        $boat       = Boat::find($boatId);

        if($boat) {
            $from       = $from ? new Carbon($from, config('app.timezone')) : null;
            $until      = $until ? new Carbon($until, config('app.timezone')) : null;
            try {
                $boatPrice = new BoatPrice($boat, $from, $until);
                $response  = $boatPrice->getPrice($request);
            } catch(\Exception $e) {
                $response = ['error' => $e->getMessage()];
            }

            return response()->json($response);
        }
    }

    /**
     * Calculate boat dates price.
     *
     * @param  Request $request
     * @return Response
     */
    public function calculateGuestBoatPrices(Request $request)
    {
        $name       = $request->post('name');
        $from       = $request->post('from');
        $until      = $request->post('until');
        $length     = $request->post('length');
        $persons    = $request->post('persons');
        $response   = ['error' => true];

        $guestBoat  = GuestBoat::whereName($name)->whereLength($length)->first();

        if($from && $until && $length && $persons) {
            $from       = new Carbon($from, config('app.timezone'));
            $until      = new Carbon($until, config('app.timezone'));
            $response   = (new GuestBoatPrice($guestBoat, $from, $until))->getPrice($request);
        }

        return response()->json($response);
    }

    /**
     * Calculate rental dates price.
     *
     * @param  Request $request
     * @return Response
     */
    public function calculateRentalPrices(Request $request)
    {
        $from           = $request->post('from');
        $until          = $request->post('until');
        $rentableId     = $request->post('rentable_id');
        $rentableType   = $request->post('rentable_type');
        $class          = Relation::getMorphedModel($rentableType);
        $rentable       = ($class)::find($rentableId);
        $response       = ['error' => 'unknown error'];

        try {
            if($rentable && $from && $until) {
                $from       = new Carbon($from, config('app.timezone'));
                $until      = new Carbon($until, config('app.timezone'));
                $response   = (new RentablePrice($rentable, $from, $until))->getPrice($request);
            }
        } catch(Exception $e) {
            $response = ['error' => $e->getMessage()];
        }

        return response()->json($response);
    }

    public function excelCaravanDates(?Carbon $from = null,?Carbon  $until = null)
    {
        $now = Carbon::now()->format('Ymd-Hi');
        $fileName = $now.'_caravan_dates.xls';
        $export = new CaravanDatesExport($from, $until);

        return $export->download($fileName, Excel::XLS);
    }

    public function excelBoatDates(?Carbon $from = null,?Carbon  $until = null)
    {
        $now = Carbon::now()->format('Ymd-Hi');
        $fileName = $now.'_boat_dates.xls';
        $export = new BoatDatesExport($from, $until);

        return $export->download($fileName, Excel::XLS);
    }

    public function excelGuestBoatDates(?Carbon $from = null,?Carbon  $until = null)
    {
        $now = Carbon::now()->format('Ymd-Hi');
        $fileName = $now.'_gueat_boat_dates.xls';
        $export = new GuestBoatDatesExport($from, $until);

        return $export->download($fileName, Excel::XLS);
    }

    public function excelRentalDates($rentable, ?Carbon $from = null,?Carbon  $until = null)
    {
        $now = Carbon::now()->format('Ymd-Hi');
        $fileName = $now.'_'.$rentable.'_dates.xls';
        $export = new RentalsExport($rentable, $from, $until);

        return $export->download($fileName, Excel::XLS);
    }

    public function pdfGuestBoatDates(Carbon $from, ?Carbon  $until = null)
    {
        $data = GuestBoatDates::with('boat')
            ->datesBetween($from, $until)
            ->orderBy('from')
            ->get();
        return $data;
    }

    public function pdfRentalDates(Carbon $from, ?Carbon  $until = null)
    {
        return Rentable::with('customer')
            ->datesBetween($from, $until)
            ->orderBy('from')
            ->get();
    }

    public function pdfBoatDates(Carbon $from, ?Carbon  $until = null)
    {
        $data = BoatDates::with('boat')
            ->datesBetween($from, $until)
            ->orderBy('from')
            ->get();
        return $data;
    }

    public function pdfCaravanDates(Carbon $from, ?Carbon  $until = null)
    {
        $data = CaravanDates::with('caravan')
            ->datesBetween($from, $until)
            ->orderBy('from')
            ->get();
        return $data;
    }
}

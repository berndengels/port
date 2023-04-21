<?php
namespace App\Libs\Sanitizers;

use App\Models\CaravanDates;
use Exception;
use Illuminate\Http\Request;
use App\Libs\Prices\CaravanPrice;

class CaravanSanitizer extends Sanitizer
{
    protected static $model = CaravanDates::class;

    public function sanitize(CaravanDates $caravanDate)
    {
            $from = $caravanDate->from;
            $until = $caravanDate->until;
            $params = [
                'from'      => $caravanDate->from->format('Y-m-d'),
                'until'     => $caravanDate->until->format('Y-m-d'),
                'persons'   => $caravanDate->persons,
                'electric'  => $caravanDate->electric,
            ];

            $request = new Request();
            $request->request->add($params);
            try {
                $response = (new CaravanPrice($from, $until, $caravanDate->caravan))->getPrice($request);
                $caravanDate->prices = json_encode($response);
                $caravanDate->save();
                return true;
            } catch(Exception $e) {
                echo $e->getMessage();
                return false;
            }
    }
}

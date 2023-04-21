<?php
namespace App\Libs\Sanitizers;

use Exception;
use Illuminate\Http\Request;
use App\Models\HouseboatRentals;
use App\Libs\Prices\HouseboatPrice;

class HouseBoatSanitizer extends Sanitizer
{
    protected static $model = HouseboatRentals::class;

    public function sanitize(HouseboatRentals $houseboatDate)
    {
        $from   = $houseboatDate->from;
        $until  = $houseboatDate->until;
        $params = [
            'from'  => $houseboatDate->from->format('Y-m-d'),
            'until' => $houseboatDate->until->format('Y-m-d'),
        ];

        $request = new Request();
        $request->request->add($params);
        try {
            $response = (new HouseboatPrice($from, $until, $houseboatDate->houseboat))->getPrice($request);
            $houseboatDate->prices = json_encode($response);
            $houseboatDate->save();
            return true;
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

<?php
namespace App\Libs\Sanitizers;

use App\Libs\Prices\BoatPrice;
use App\Libs\Prices\CaravanPrice;
use App\Models\BoatDates;
use App\Models\CaravanDates;
use Exception;
use Illuminate\Http\Request;

class BoatSanitizer extends Sanitizer
{
    protected static $model = BoatDates::class;

    public function sanitize(BoatDates $boatDate)
    {
        $from   = $boatDate->from;
        $until  = $boatDate->until;
        $params = [
            'from'          => $boatDate->from->format('Y-m-d'),
            'until'         => $boatDate->until->format('Y-m-d'),
            'modus'         => $boatDate->modus,
            'length'        => $boatDate->boat->length,
            'width'         => $boatDate->boat->width,
            'weight'        => $boatDate->boat->weight,
            'mast_length'   => $boatDate->boat->length,
            'mast_weight'   => $boatDate->boat->length,
            'crane'         => $boatDate->boat->length,
            'mast_crean'    => $boatDate->boat->length,
            'cleaning'      => $boatDate->boat->length,
        ];

        $request = new Request();
        $request->request->add($params);
        try {
            $response = (new BoatPrice($from, $until))->getPrice($request);
            $boatDate->prices = json_encode($response);
            $boatDate->save();
            return true;
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
}

<?php
namespace App\Libs\Sanitizers;

use Exception;
use App\Models\BoatDates;
use Illuminate\Http\Request;
use App\Libs\Prices\BoatPrice;

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
            'mast_length'   => $boatDate->boat->mast_length,
            'mast_weight'   => $boatDate->boat->mast_weight,
            'crane'         => (bool) $boatDate->hasCrane,
            'mast_crean'    => (bool) $boatDate->hasMastCrean,
            'cleaning'      => (bool) $boatDate->hasCleaning,
            'transport'     => (bool) $boatDate->hasTransport,
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

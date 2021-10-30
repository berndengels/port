<?php
namespace App\Libs\Sanitizers;

use App\Libs\Prices\BoatGuestPrice;
use App\Libs\Prices\BoatPrice;
use App\Models\BoatDates;
use App\Models\BoatGuestDates;
use Exception;
use Illuminate\Http\Request;

class GuestBoatSanitizer extends Sanitizer
{
    protected static $model = BoatGuestDates::class;

    public function sanitize(BoatGuestDates $guestBoatDate)
    {
        $from   = $guestBoatDate->from;
        $until  = $guestBoatDate->until;
        $params = [
            'from'      => $guestBoatDate->from->format('Y-m-d'),
            'until'     => $guestBoatDate->until->format('Y-m-d'),
            'length'    => $guestBoatDate->boat->length,
            'persons'   => $guestBoatDate->persons,
            'electric'  => $guestBoatDate->electric,
            'day_price' => $guestBoatDate->day_price,
        ];

        $request = new Request();
        $request->request->add($params);
        try {
            $response = (new BoatGuestPrice($from, $until))->getPrice($request);
            $guestBoatDate->prices = json_encode($response);
            $guestBoatDate->save();
            return true;
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

}

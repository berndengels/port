<?php

namespace App\Libs\Sanitizers;

use Exception;
use App\Libs\Prices\GuestBoatPrice;
use App\Models\BoatGuestDates;
use App\Models\GuestBoatDates;
use Illuminate\Http\Request;

class GuestBoatSanitizer extends Sanitizer
{
    protected static $model = BoatGuestDates::class;

    public function sanitize(GuestBoatDates $guestBoatDate)
    {
        $from   = $guestBoatDate->from;
        $until  = $guestBoatDate->until;
        $params = [
            'from'      => $guestBoatDate->from->format('Y-m-d'),
            'until'     => $guestBoatDate->until->format('Y-m-d'),
            'persons'   => $guestBoatDate->persons,
            'electric'  => $guestBoatDate->electric,
        ];

        $request = new Request();
        $request->request->add($params);
        try {
            $response = (new GuestBoatPrice($from, $until, $guestBoatDate->boat))->getPrice($request);
            $guestBoatDate->prices = json_encode($response);
            $guestBoatDate->save();
            return true;
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

}

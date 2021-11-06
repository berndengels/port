<?php

namespace App\Http\Controllers;

use App\Models\Caravan;
use Illuminate\Http\Request;
use App\Models\CarLicensePlate;

class CarLicensePlateController extends Controller
{
    public function info(Caravan $caravan)
    {
        //
        if($caravan->country->code === 'DE' && preg_match("/^[a-z]{1,3}\-/i", $caravan->carnumber)) {
            list($code,) = explode('-', $caravan->carnumber);
            $data = CarLicensePlate::where('code', '=', $code)->get()->first();
            $response = ['error' => null, 'data' => $data];
        } else {
            $response = ['error' => 'no data', 'data' => null];
        }
        return response()->json($response);
    }
}

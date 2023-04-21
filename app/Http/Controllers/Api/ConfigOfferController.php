<?php

namespace App\Http\Controllers\Api;

use App\Models\ConfigOffer;
use App\Http\Controllers\Controller;

class ConfigOfferController extends Controller
{
    public function index() {

        $data = ConfigOffer::all()->keyBy(fn($item) => class_basename($item->model))->map->enabled;
        return response()->json($data);
    }
}

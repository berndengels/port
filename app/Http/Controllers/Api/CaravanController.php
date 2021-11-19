<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaravanDates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CaravanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function stats(Request $request)
    {
        $query = CaravanDates::groupBy(['from'])
            ->selectRaw('`from`, COUNT(*) AS count')
            ->orderBy('from')
        ;

        $data = $query->get()
            ->map(fn($item) => [
                'from'  => $item->from->format('d.m.Y'),
                'count' => $item->count
            ])
        ;

        return response()->json($data);
    }
}

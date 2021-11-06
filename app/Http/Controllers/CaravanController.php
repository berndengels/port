<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Caravan;
use Illuminate\Pipeline\Pipeline;
use App\Filters\Caravan\CaravanFilter;
use Illuminate\Http\Response;
use App\Http\Requests\CaravanRequest;
use Illuminate\Support\Facades\Redirect;

class CaravanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  Caravan $caravan
     * @return Response
     */
    public function show(Caravan $caravan)
    {
        return Inertia::render('Caravans/show', compact('caravan'));
    }
}

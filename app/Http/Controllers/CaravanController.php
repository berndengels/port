<?php

namespace App\Http\Controllers;

use App\Http\Requests\Helper\Fix;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;
use App\Models\Caravan;
use Illuminate\Http\Response;
use App\Http\Requests\CaravanRequest;
use Illuminate\Support\Facades\Redirect;

class CaravanController extends Controller
{
    use Fix;
    private $countries;

    public function __construct()
    {
        $this->countries = Country::orderBy('de')
            ->get(['id','de'])
            ->keyBy('id')
            ->map
            ->de
        ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        Caravan::all()->each(function ($c) {
            $c->carnumber = $this->fixCarNumber($c->carnumber);
            $c->save();
        });
//        $caravans = Caravan::orderBy('carnumber')->paginate(3);
        $caravans = Caravan::orderBy('carnumber')->get();
        return Inertia::render('Caravans/index', [
            'data'          => $caravans,
            'create_url'    => URL::route('caravans.create'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('Caravans/create', [
            'countries' => $this->countries,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CaravanRequest $request)
    {
        Caravan::create($request->validated());
        return Redirect::route('caravans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Caravan $caravan
     * @return Response
     */
    public function show(Caravan $caravan)
    {
        return Inertia::render('Caravans/show', compact('caravan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Caravan $caravan
     * @return Response
     */
    public function edit(Caravan $caravan)
    {
        $countries = $this->countries;
        return Inertia::render('Caravans/edit', compact('caravan','countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CaravanRequest $request
     * @param Caravan $caravan
     * @return Response
     */
    public function update(CaravanRequest $request, Caravan $caravan)
    {
        $caravan->update($request->validated());
        return Redirect::route('caravans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Caravan $caravan
     * @return Response
     */
    public function destroy(Caravan $caravan)
    {
        $caravan->delete();
        return Redirect::route('caravans.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\Caravan;
use App\Models\CaravanDates;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\CaravanDatesRequest;

class CaravanDatesController extends Controller
{
    private $caravans;

    public function __construct()
    {
        $this->caravans = Caravan::orderBy('carnumber')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('CaravanDates/index', [
            'data' => CaravanDates::with('caravan')->orderBy('from','DESC')->get()->map(function ($item) {
                return [
                    'id'        => $item->id,
                    'carnumber' => $item->caravan->carnumber ?? null,
                    'carlength' => $item->caravan->carlength ?? null,
                    'from'      => $item->from,
                    'until'     => $item->until,
                    'persons'   => $item->persons,
                    'price'     => $item->price,
                    'show_url'  => URL::route('caravanDates.show', ['caravanDates' => $item]),
                    'edit_url'  => URL::route('caravanDates.edit', ['caravanDates' => $item]),
                ];
            }),
            'create_url' => URL::route('caravanDates.create'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('CaravanDates/create', ['caravans' => $this->caravans]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(CaravanDatesRequest $request)
    {
        CaravanDates::create($request->validated());
        return Redirect::route('caravanDates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param CaravanDates $caravanDates
     * @return Response
     */
    public function show(CaravanDates $caravanDates)
    {
        return Inertia::render('CaravanDates/show', compact('caravanDates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CaravanDates $caravanDates
     * @return Response
     */
    public function edit(CaravanDates $caravanDates)
    {
        $caravans = $this->caravans;
        return Inertia::render('CaravanDates/edit', compact('caravanDates','caravans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CaravanDates $caravanDates
     * @return Response
     */
    public function update(CaravanDatesRequest $request, CaravanDates $caravanDates)
    {
        $caravanDates->update($request->validated());
        return Redirect::route('caravanDates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CaravanDates $caravanDates
     * @return Response
     */
    public function destroy(CaravanDates $caravanDates)
    {
        $caravanDates->delete();
        return Redirect::route('caravanDates.index');
    }
}

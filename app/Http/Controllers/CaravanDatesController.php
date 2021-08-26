<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Caravan;
use App\Models\CaravanDates;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
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
                    'prices'    => $item->prices,
                    'days'      => $item->days,
                    'show_url'  => URL::route('caravanDates.show', ['caravanDate' => $item]),
                    'edit_url'  => URL::route('caravanDates.edit', ['caravanDate' => $item]),
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
        $caravanId = $request->post('caravan_id');
        $validated = collect($request->validated());

        $caravan = $caravanId > 0 ? Caravan::find($caravanId) : new Caravan();
        $caravan->dates()->create($validated->except(['carnumber','carlength'])->toArray());
//        CaravanDates::create($validated->except(['carnumber','carlength']))->caravan;

        return Redirect::route('caravanDates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param CaravanDates $caravanDate
     * @return Response
     */
    public function show(CaravanDates $caravanDate)
    {
        return Inertia::render('CaravanDates/show', compact('caravanDate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CaravanDates $caravanDate
     * @return Response
     */
    public function edit(CaravanDates $caravanDate)
    {
        $caravans = $this->caravans;
        $caravanDate->load('caravan');
        return Inertia::render('CaravanDates/edit', compact('caravanDate','caravans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CaravanDates $caravanDate
     * @return Response
     */
    public function update(CaravanDatesRequest $request, CaravanDates $caravanDate)
    {
        $caravanDate->update($request->validated());
        return Redirect::route('caravanDates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CaravanDates $caravanDate
     * @return Response
     */
    public function destroy(CaravanDates $caravanDate)
    {
        $caravanDate->delete();
        return Redirect::route('caravanDates.index');
    }
}

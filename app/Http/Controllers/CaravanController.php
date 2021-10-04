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
    private $countries;
    /**
     * @var Collection
     */
    private $caravanOptions;

    public function __construct()
    {
        $this->countries = Country::orderBy('de')
            ->get(['id','de'])
            ->keyBy('id')
            ->map
            ->de
        ;
        $this->caravanOptions = Caravan::orderBy('carnumber')
            ->get()
            ->keyBy('id')
            ->map
            ->carnumber;
        $this->caravanOptions->prepend('Kennzeichen suchen','');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $caravanId = $request->input('caravan');

        $data = Caravan::orderBy('carnumber')
            ->caravan($caravanId)
            ->paginate(config('port.main.default.pagination.limit'))
        ;

        return view('admin.caravans.index', [
            'caravanOptions'    => $this->caravanOptions,
            'data'              => $data,
            'caravanId'         => $caravanId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.caravans.create', [
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

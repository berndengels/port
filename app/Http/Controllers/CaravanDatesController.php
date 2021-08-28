<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Caravan;
use App\Models\CaravanDates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CaravanDatesRequest;

class CaravanDatesController extends Controller
{
    private $caravans;
    private $years;
    private $monthsByYear;

    public function __construct()
    {
        $this->caravans = Caravan::orderBy('carnumber')->get();
        $this->monthsByYear = CaravanDates::getMonthsByYears();
        $this->years = array_keys($this->monthsByYear);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('CaravanDates/index', [
            'years'         => $this->years,
            'monthsByYear'  => $this->monthsByYear,
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
        $carnumber  = $request->post('carnumber');
        $caravan    = Caravan::whereCarnumber($carnumber)->first() ?? new Caravan();
        $validated  = collect($request->validated());

        $caravan->fill($validated->only(['carnumber','carlength'])->toArray())->save();
        $caravan->dates()->create($validated->except(['carnumber','carlength'])->toArray());

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
        $caravanDate->load('caravan');
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
     * @param CaravanDatesRequest $request
     * @param CaravanDates $caravanDate
     * @return Response
     */
    public function update(CaravanDatesRequest $request, CaravanDates $caravanDate)
    {
        $validated = collect($request->validated());
        $validatedCaravan = $validated->only(['carnumber','carlength'])->toArray();

        $validatedCaravanDates = $validated->except(['carnumber','carlength'])->toArray();
        $caravanDate->caravan()->update($validatedCaravan);
        $caravanDate->update($validatedCaravanDates);

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

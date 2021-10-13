<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BoatDatesRequest;
use App\Models\Boat;
use App\Models\BoatDates;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminBoatDatesController extends AdminController
{
    protected $boatOptions;
    protected $datesModi;

    public function __construct()
    {
        $boats = Boat::orderBy('boat_name')->get();
        $this->boatOptions = $boats->keyBy('id')->map->boat_name->prepend('Boot wählen','');
        $this->datesModi = config('port.main.boat.dates.modi');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /**
         * @var $query Builder
         */
        $query = BoatDates::with('boat')
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);
        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(function ($item) {
            return $item->price;
        });

        return view('admin.boatDates.index', compact('data','priceTotal'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function saison()
    {
        $modus = 'saison';
        /**
         * @var $query Builder
         */
        $query = BoatDates::with('boat')
            ->whereModus('saison')
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);
        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(function ($item) {
            return $item->price;
        });

        return view('admin.boatDates.index', compact('data','modus', 'priceTotal'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function winter()
    {
        $modus = 'winter';
        /**
         * @var $query Builder
         */
        $query = BoatDates::with('boat')
            ->whereModus('winter')
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);
        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(function ($item) {
            return $item->price;
        });

        return view('admin.boatDates.index', compact('data','modus', 'priceTotal'));
    }

    /**
     * Display the specified resource.
     *
     * @param BoatDates $boatDates
     * @return Response
     */
    public function show(BoatDates $boatDates)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $today = Carbon::today();
        $year = $today->format('Y');
        $nextYear = $today->copy()->addYear()->format('Y');

        if('saison' === $request->modus) {
            $defaultFrom    = Carbon::create($year .'-'. config('port.prices.boat.saison_start'));
            $defaultUntil   = Carbon::create($year .'-'. config('port.prices.boat.saison_end'));
        } else {
            $defaultFrom    = Carbon::create($year .'-'. config('port.prices.boat.winter_start'));
            $defaultUntil   = Carbon::create($nextYear .'-'. config('port.prices.boat.winter_end'));
        }
        return view('admin.boatDates.create', [
            'modus'         => $request->modus,
            'datesModi'     => $this->datesModi,
            'boatOptions'   => $this->boatOptions,
            'defaultFrom'   => $defaultFrom->format('Y-m-d'),
            'defaultUntil'  => $defaultUntil->format('Y-m-d'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BoatDatesRequest $request
     * @return Response
     */
    public function store(BoatDatesRequest $request)
    {
        $validated  = $request->validated();
        $modus      = $validated['modus'];
        try {
            BoatDates::create($validated);
            return redirect()->route('admin.boatDates.'.$modus)->with('success', 'Boot Date erfogreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatDates.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BoatDates $boatDates
     * @return Response
     */
    public function edit(BoatDates $boatDate)
    {
        $boatDate->load('boat');
        return view('admin.boatDates.edit', [
            'boatDate'      => $boatDate,
            'modus'         => $boatDate->modus,
            'datesModi'     => $this->datesModi,
            'boatOptions'   => $this->boatOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BoatDatesRequest $request
     * @param BoatDates $boatDates
     * @return Response
     */
    public function update(BoatDatesRequest $request, BoatDates $boatDate)
    {
        $validated = $request->validated();
        try {
            $boatDate->update($validated);
            return redirect()->route('admin.boatDates.index')->with('success', 'Boot Date erfogreich geändert!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatDates.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BoatDates $boatDates
     * @return Response
     */
    public function destroy(BoatDates $boatDate)
    {
        try {
            $boatDate->delete();
            return redirect()->route('admin.boatDates.index')->with('success', 'Boot Date erfogreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatDates.index')->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Boat;
use App\Models\BoatDates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminBoatDatesController extends AdminController
{
    protected $boatOptions;

    public function __construct()
    {
        $boats = Boat::orderBy('boat_name')->get();
        $this->boatOptions = $boats->keyBy('id')->map->boat_name->prepend('Boot wählen','');
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
        $query = BoatDates::with('customer')
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);

        return view('admin.boatDates.index', compact('data'));
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
        $query = BoatDates::with('customer')
            ->whereModus('saison')
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);

        return view('admin.boatDates.index', compact('data','modus'));
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
        $query = BoatDates::with('customer')
            ->whereModus('winter')
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);
        return view('admin.boatDates.index', compact('data','modus'));
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
        return view('admin.boatDates.create', [
            'modus' => $request->modus,
            'boatOptions' => $this->boatOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BoatDates $boatDates
     * @return Response
     */
    public function edit(BoatDates $boatDates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BoatDates $boatDates
     * @return Response
     */
    public function update(Request $request, BoatDates $boatDates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BoatDates $boatDates
     * @return Response
     */
    public function destroy(BoatDates $boatDates)
    {
        //
    }
}

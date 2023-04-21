<?php

namespace App\Http\Controllers\Admin;

use App\Models\House;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\HouseModel;
use App\Repositories\HouseModelRepository;

class AdminHouseController extends AdminController
{
    protected $models;
    public function __construct()
    {
        parent::__construct();
        $this->models = $this->houseModelRepository
            ->options()
            ->getSelectOptions()
            ->prepend('Bitte wählen', null);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = House::paginate($this->paginatorLimit);
        return view('admin.houses.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function show(House $house)
    {
        return view('admin.houses.show', compact('house'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.houses.create', [
            'models' => $this->models,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreHouseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHouseRequest $request)
    {
        try {
            House::create($request->validated());
            return redirect()->route('admin.houses.index')->with('success', 'Haus erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.houses.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function edit(House $house)
    {
        return view('admin.houses.edit', [
            'house' => $house,
            'models' => $this->models,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateHouseRequest  $request
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHouseRequest $request, House $house)
    {
        try {
            $house->update($request->validated());
            return redirect()->route('admin.houses.index')->with('success', 'Haus erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.houses.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function destroy(House $house)
    {
        try {
            $house->delete();
            return redirect()->route('admin.houses.index')->with('success', 'Haus erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.houses.index')->with('error', $e->getMessage());
        }
    }
}

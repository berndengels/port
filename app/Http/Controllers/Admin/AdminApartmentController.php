<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apartment;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;

class AdminApartmentController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Apartment::paginate($this->paginatorLimit);
        return view('admin.apartments.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        return view('admin.apartments.show', compact('apartment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.apartments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreApartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartmentRequest $request)
    {
        try {
            Apartment::create($request->validated());
            return redirect()->route('admin.apartments.index')->with('success', 'Apartment erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.apartments.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        return view('admin.apartments.edit', compact('apartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateApartmentRequest  $request
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        try {
            $apartment->update($request->validated());
            return redirect()->route('admin.apartments.index')->with('success', 'Apartment erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.apartments.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        try {
            $apartment->delete();
            return redirect()->route('admin.apartments.index')->with('success', 'Apartment erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.apartments.index')->with('error', $e->getMessage());
        }
    }
}

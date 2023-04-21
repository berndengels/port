<?php

namespace App\Http\Controllers\Admin;

use App\Models\ApartmentModel;
use App\Http\Requests\StoreApartmentModelRequest;
use App\Http\Requests\UpdateApartmentModelRequest;

class AdminApartmentModelController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ApartmentModel::paginate($this->paginatorLimit);
        return view('admin.apartmentModels.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ApartmentModel  $apartmentModel
     * @return \Illuminate\Http\Response
     */
    public function show(ApartmentModel $apartmentModel)
    {
        return view('admin.apartmentModels.show', compact('apartmentModel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.apartmentModels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreApartmentModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartmentModelRequest $request)
    {
        try {
            ApartmentModel::create($request->validated());
            return redirect()->route('admin.apartmentModels.index')->with('success', 'Apartment-Modell erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.apartmentModels.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ApartmentModel  $apartmentModel
     * @return \Illuminate\Http\Response
     */
    public function edit(ApartmentModel $apartmentModel)
    {
        return view('admin.apartmentModels.edit', compact('apartmentModel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateApartmentModelRequest  $request
     * @param  \App\Models\ApartmentModel  $apartmentModel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentModelRequest $request, ApartmentModel $apartmentModel)
    {
        try {
            $apartmentModel->update($request->validated());
            return redirect()->route('admin.apartmentModels.index')->with('success', 'Apartment-Modell erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.apartmentModels.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ApartmentModel  $apartmentModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApartmentModel $apartmentModel)
    {
        try {
            $apartmentModel->delete();
            return redirect()->route('admin.apartmentModels.index')->with('success', 'Apartment-Modell erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.apartmentModels.index')->with('error', $e->getMessage());
        }
    }
}

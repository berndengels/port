<?php

namespace App\Http\Controllers\Admin;

use App\Models\HouseModel;
use App\Http\Requests\StoreHouseModelRequest;
use App\Http\Requests\UpdateHouseModelRequest;
use App\Models\Media;

class AdminHouseModelController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = HouseModel::paginate($this->paginatorLimit);
        return view('admin.houseModels.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HouseModel  $houseModel
     * @return \Illuminate\Http\Response
     */
    public function show(HouseModel $houseModel)
    {
        return view('admin.houseModels.show', compact('houseModel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.houseModels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreHouseModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHouseModelRequest $request)
    {
        try {
            HouseModel::create($request->validated());
            return redirect()->route('admin.houseModels.index')->with('success', 'Haus-Modell erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseModels.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HouseModel  $houseModel
     * @return \Illuminate\Http\Response
     */
    public function edit(HouseModel $houseModel)
    {
        $files = $houseModel->getMedia('houseModel')->map(fn(Media $m) => [
            'id'=> $m->id,
            'name' => $m->name,
            'url'  => $m->getUrl('thumb')
        ])->toJson(true);

        return view('admin.houseModels.edit', compact('houseModel','files'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateHouseModelRequest  $request
     * @param  \App\Models\HouseModel  $houseModel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHouseModelRequest $request, HouseModel $houseModel)
    {
        try {
            $houseModel->update($request->validated());
            return redirect()->route('admin.houseModels.index')->with('success', 'Haus-Modell erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseModels.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HouseModel  $houseModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(HouseModel $houseModel)
    {
        try {
            $houseModel->delete();
            return redirect()->route('admin.houseModels.index')->with('success', 'Haus-Modell erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseModels.index')->with('error', $e->getMessage());
        }
    }
}

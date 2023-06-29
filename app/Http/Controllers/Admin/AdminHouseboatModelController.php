<?php

namespace App\Http\Controllers\Admin;

use App\Models\HouseboatModel;
use App\Http\Requests\HouseboatModelsRequest;
use App\Models\Media;
use Illuminate\Http\Response;

class AdminHouseboatModelController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = HouseboatModel::paginate($this->paginatorLimit);
        return view('admin.houseboatModels.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param HouseboatModel $houseboatModel
     * @return Response
     */
    public function show(HouseboatModel $houseboatModel)
    {
        return view('admin.houseboatModels.show', compact('houseboatModel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.houseboatModels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  HouseboatModelsRequest  $request
     * @return Response
     */
    public function store(HouseboatModelsRequest $request)
    {
        try {
            HouseboatModel::create($request->validated());
            return redirect()->route('admin.houseboatModels.index')->with('success', 'Hausboot-Modell erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseboatModels.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HouseboatModel $houseboatModel
     * @return Response
     */
    public function edit(HouseboatModel $houseboatModel)
    {
        $files = $houseboatModel->getMedia('houseboatModel')->map(fn(Media $m) => [
            'id'=> $m->id,
            'name' => $m->name,
            'url'  => $m->getUrl('thumb')
        ])->toJson(true);

        return view('admin.houseboatModels.edit', compact('houseboatModel','files'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HouseboatModelsRequest  $request
     * @param HouseboatModel $houseboatModel
     * @return Response
     */
    public function update(HouseboatModelsRequest $request, HouseboatModel $houseboatModel)
    {
        try {
            $houseboatModel->update($request->validated());
            return redirect()->route('admin.houseboatModels.index')->with('success', 'Hausboot-Modell erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseboatModels.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HouseboatModel $houseboatModel
     * @return Response
     */
    public function destroy(HouseboatModel $houseboatModel)
    {
        try {
            $houseboatModel->delete();
            return redirect()->route('admin.houseboatModels.index')->with('success', 'Hausboot-Modell erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.houseboatModels.index')->with('error', $e->getMessage());
        }
    }
}

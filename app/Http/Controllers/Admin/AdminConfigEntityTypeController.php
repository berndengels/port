<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigEntityType;
use App\Http\Requests\ConfigEntityTypeRequest;
use App\Models\ConfigHasPriceComponent;
use App\Models\ConfigPriceComponent;
use Illuminate\Http\Response;

class AdminConfigEntityTypeController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigEntityType::with('priceComponents')->paginate($this->paginatorLimit);
//        dd($data->items());
        return view('admin._config.entityTypes.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigEntityType $entityType
     * @return Response
     */
    public function show(ConfigEntityType $entityType)
    {
        return view('admin._config.entityTypes.show', compact('entityType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.entityTypes.create', [
            'optionsPriceComponents'  => $this->configPriceComponentRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigEntityTypeRequest  $request
     * @return Response
     */
    public function store(ConfigEntityTypeRequest $request)
    {
        try {
            ConfigEntityType::create($request->validated());
            return redirect()->route('admin.config.entityTypes.index')->with('success', 'Entity Typ erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigEntityType $entityType
     * @return Response
     */
    public function edit(ConfigEntityType $entityType)
    {
        $entityType->load('priceComponents');
        $entityType->priceComponents()->get();
        return view('admin._config.entityTypes.edit', [
            'entityType'  => $entityType,
            'optionsPriceComponents'  => $this->configPriceComponentRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConfigEntityTypeRequest  $request
     * @param ConfigEntityType $entityType
     * @return Response
     */
    public function update(ConfigEntityTypeRequest $request, ConfigEntityType $entityType)
    {
        try {
            $entityType->update($request->validated());
            return redirect()->route('admin.config.entityTypes.index')->with('success', 'Entity Typ erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigEntityType $entityType
     * @return Response
     */
    public function destroy(ConfigEntityType $entityType)
    {
        try {
            $entityType->delete();
            return redirect()->route('admin.config.entityTypes.index')->with('success', 'Entity Typ erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

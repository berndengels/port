<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigEntityType;
use App\Http\Requests\ConfigEntityTypeRequest;
use App\Models\ConfigHasPriceComponent;
use App\Models\ConfigPriceComponent;

class AdminConfigEntityTypeController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ConfigEntityType::paginate($this->paginatorLimit);
        return view('admin._config.entityTypes.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConfigEntityType  $entityType
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigEntityType $entityType)
    {
        return view('admin._config.entityTypes.show', compact('entityType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
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
     * @param  \App\Models\ConfigEntityType  $entityType
     * @return \Illuminate\Http\Response
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
     * @param  \App\Models\ConfigEntityType  $entityType
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigEntityTypeRequest $request, ConfigEntityType $entityType)
    {
        try {
            $priceComponents = $request->validated()['priceComponents'] ?? null;
            $entityType->update($request->validated());

            if($priceComponents) {
                $priceComponents = ConfigPriceComponent::findMany($priceComponents);
                ConfigHasPriceComponent::whereHasPriceComponentType($entityType->model)->delete();
                $priceComponents->each(fn($c) =>
                    ConfigHasPriceComponent::create([
                        'has_price_component_id'    => $entityType->id,
                        'has_price_component_type'  => ConfigEntityType::class,
                        'config_price_component_id' => $c->id,
                    ])
                );
            }

            return redirect()->route('admin.config.entityTypes.index')->with('success', 'Entity Typ erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConfigEntityType  $entityType
     * @return \Illuminate\Http\Response
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigPriceComponentRequest;
use App\Http\Requests\StoreConfigPriceComponentRequest;
use App\Http\Requests\UpdateConfigPriceComponentRequest;
use App\Models\ConfigPriceComponent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminConfigPriceComponentController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigPriceComponent::with(['entities','priceType','service','unitRangeType'])->paginate($this->paginatorLimit);
        return view('admin._config.priceComponents.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigPriceComponent $configPriceComponent
     * @return Response
     */
    public function show(ConfigPriceComponent $configPriceComponent)
    {
        return view('admin._config.priceComponents.show', compact('configPriceComponent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.priceComponents.create', [
            'optionsPriceComponents'  => $this->configPriceComponentRepository->options()->getSelectOptions(),
            'optionsEntityTypes' => $this->configEntityTypeRepository->options('model')->translate()->getSelectOptions(),
            'optionsPriceTypes' => $this->configPriceTypeRepository->options()->getSelectOptions(),
            'optionsServices' => $this->configServiceRepository->options()->getSelectOptions()->prepend('Bitte wählen', null),
			'optionsUnitRangeTypes' => $this->configUnitRangeTypeRepository->options()->getSelectOptions()->prepend('Bitte wählen', null),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreConfigPriceComponentRequest  $request
     * @return Response
     */
    public function store(StoreConfigPriceComponentRequest $request)
    {
        try {
            $validated = $request->validated();
            $priceComponent = ConfigPriceComponent::create($validated);

            if($validated['entities']) {
                $priceComponent->entities()->sync($validated['entities']);
            }

            return redirect()->route('admin.configPriceComponents.index')->with('success', 'Preis Komponente erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigPriceComponent $configPriceComponent
     * @return Response
     */
    public function edit(ConfigPriceComponent $configPriceComponent)
    {
        return view('admin._config.priceComponents.edit', [
            'configPriceComponent'  => $configPriceComponent,
            'optionsPriceComponents'  => $this->configPriceComponentRepository->options()->getSelectOptions(),
            'optionsEntityTypes' => $this->configEntityTypeRepository->options('model')->translate()->getSelectOptions(),
            'optionsPriceTypes' => $this->configPriceTypeRepository->options()->getSelectOptions(),
            'optionsServices' => $this->configServiceRepository->options()->getSelectOptions()->prepend('Bitte wählen', null),
			'optionsUnitRangeTypes' => $this->configUnitRangeTypeRepository->options()->getSelectOptions()->prepend('Bitte wählen', null),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateConfigPriceComponentRequest  $request
     * @param ConfigPriceComponent $configPriceComponent
     * @return Response
     */
    public function update(UpdateConfigPriceComponentRequest $request, ConfigPriceComponent $configPriceComponent)
    {
        try {
            $validated = $request->validated();
			$configPriceComponent->update($validated);

            if($validated['entities']) {
				$configPriceComponent->entities()->sync($validated['entities']);
            }

            return redirect()->route('admin.configPriceComponents.index')->with('success', 'Preis Komponente erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigPriceComponent $configPriceComponent
     * @return Response
     */
    public function destroy(ConfigPriceComponent $configPriceComponent)
    {
        try {
			$configPriceComponent->delete();
            return redirect()->route('admin.configPriceComponents.index')->with('success', 'Preis Komponente erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

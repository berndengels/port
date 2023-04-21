<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigPriceComponentRequest;
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
        $data = ConfigPriceComponent::with(['entities','priceType','service'])
            ->paginate($this->paginatorLimit)
        ;
        return view('admin._config.priceComponents.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigPriceComponent $priceComponent
     * @return Response
     */
    public function show(ConfigPriceComponent $priceComponent)
    {
        //
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigPriceComponentRequest  $request
     * @return Response
     */
    public function store(ConfigPriceComponentRequest $request)
    {
        try {
            $validated = $request->validated();
            $priceComponent = ConfigPriceComponent::create($validated);

            if($validated['entities']) {
                $priceComponent->entities()->sync($validated['entities']);
            }

            return redirect()->route('admin.config.priceComponents.index')->with('success', 'Preis Komponente erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigPriceComponent $priceComponent
     * @return Response
     */
    public function edit(ConfigPriceComponent $priceComponent)
    {
        return view('admin._config.priceComponents.edit', [
            'priceComponent'  => $priceComponent,
            'optionsPriceComponents'  => $this->configPriceComponentRepository->options()->getSelectOptions(),
            'optionsEntityTypes' => $this->configEntityTypeRepository->options('model')->translate()->getSelectOptions(),
            'optionsPriceTypes' => $this->configPriceTypeRepository->options()->getSelectOptions(),
            'optionsServices' => $this->configServiceRepository->options()->getSelectOptions()->prepend('Bitte wählen', null),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConfigPriceComponentRequest  $request
     * @param ConfigPriceComponent $priceComponent
     * @return Response
     */
    public function update(ConfigPriceComponentRequest $request, ConfigPriceComponent $priceComponent)
    {
        try {
            $validated = $request->validated();
            $priceComponent->update($validated);

            if($validated['entities']) {
                $priceComponent->entities()->sync($validated['entities']);
            }

            return redirect()->route('admin.config.priceComponents.index')->with('success', 'Preis Komponente erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigPriceComponent $priceComponent
     * @return Response
     */
    public function destroy(ConfigPriceComponent $priceComponent)
    {
        try {
            $priceComponent->delete();
            return redirect()->route('admin.config.priceComponents.index')->with('success', 'Preis Komponente erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

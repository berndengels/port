<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfigPriceComponentRequest;
use App\Models\ConfigPriceComponent;
use Illuminate\Http\Request;

class AdminConfigPriceComponentController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ConfigPriceComponent::with('entities')
            ->paginate($this->paginatorLimit)
        ;
        return view('admin._config.priceComponents.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConfigPriceComponent  $priceComponent
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigPriceComponent $priceComponent)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin._config.priceComponents.create', [
            'optionsEntityTypes' => $this->configEntityTypeRepository->options('model')->getSelectOptions(),
            'optionsPriceTypes' => $this->configPriceTypeRepository->options()->getSelectOptions(),
            'optionsServices' => $this->configServiceRepository->options()->getSelectOptions()->prepend('Bitte wählen', null),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigPriceComponentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ConfigPriceComponentRequest $request)
    {
        try {
            ConfigPriceComponent::create($request->validated());
            return redirect()->route('admin.config.priceComponents.index')->with('success', 'Preis Komponente erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConfigPriceComponent  $priceComponent
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigPriceComponent $priceComponent)
    {
        return view('admin._config.priceComponents.edit', [
            'priceComponent'  => $priceComponent,
            'optionsEntityTypes' => $this->configEntityTypeRepository->options('model')->getSelectOptions(),
            'optionsPriceTypes' => $this->configPriceTypeRepository->options()->getSelectOptions(),
            'optionsServices' => $this->configServiceRepository->options()->getSelectOptions()->prepend('Bitte wählen', null),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConfigPriceComponentRequest  $request
     * @param  \App\Models\ConfigPriceComponent  $priceComponent
     * @return \Illuminate\Http\Response
     */
    public function update(ConfigPriceComponentRequest $request, ConfigPriceComponent $priceComponent)
    {
        try {
            $priceComponent->update($request->validated());
            return redirect()->route('admin.config.priceComponents.index')->with('success', 'Preis Komponente erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConfigPriceComponent  $priceComponent
     * @return \Illuminate\Http\Response
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

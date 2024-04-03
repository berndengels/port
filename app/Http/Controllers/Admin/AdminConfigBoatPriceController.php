<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigBoatPrice;
use App\Http\Requests\ConfigBoatPriceRequest;
use Illuminate\Http\Response;

class AdminConfigBoatPriceController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigBoatPrice::paginate($this->paginatorLimit);
        return view('admin._config.boatPrices.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigBoatPrice $boatPrice
     * @return Response
     */
    public function show(ConfigBoatPrice $configBoatPrice)
    {
        return view('admin._config.boatPrices.show', compact('configBoatPrice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.boatPrices.create', [
            'optionsSaisonDates' => $this->configSaisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->configPriceTypeRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigBoatPriceRequest  $request
     * @return Response
     */
    public function store(ConfigBoatPriceRequest $request)
    {
        try {
            ConfigBoatPrice::create($request->validated());
            return redirect()->route('admin.configBoatPrices.index')->with('success', 'Bootpreis erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigBoatPrice $boatPrice
     * @return Response
     */
    public function edit(ConfigBoatPrice $configBoatPrice)
    {
        return view('admin._config.boatPrices.edit', [
            'configBoatPrice' => $configBoatPrice,
            'optionsSaisonDates' => $this->configSaisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->configPriceTypeRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConfigBoatPriceRequest  $request
     * @param ConfigBoatPrice $boatPrice
     * @return Response
     */
    public function update(ConfigBoatPriceRequest $request, ConfigBoatPrice $configBoatPrice)
    {
        try {
			$configBoatPrice->update($request->validated());
            return redirect()->route('admin.configBoatPrices.index')->with('success', 'Bootpreis erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigBoatPrice $boatPrice
     * @return Response
     */
    public function destroy(ConfigBoatPrice $configBoatPrice)
    {
        try {
			$configBoatPrice->delete();
            return redirect()->route('admin.configBoatPrices.index')->with('success', 'Bootpreis erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

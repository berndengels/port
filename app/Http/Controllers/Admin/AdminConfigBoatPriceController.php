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
    public function show(ConfigBoatPrice $boatPrice)
    {
        return view('admin._config.boatPrices.show', compact('boatPrice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.boatPrices.create', [
            'optionsSaisonDates' => $this->saisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->priceTypeRepository->options()->getSelectOptions(),
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
            return redirect()->route('admin._config.boatPrices.index')->with('success', 'Bootpreis erfolgreich angelegt!');
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
    public function edit(ConfigBoatPrice $boatPrice)
    {
        return view('admin._config.boatPrices.edit', [
            'boatPrice' => $boatPrice,
            'optionsSaisonDates' => $this->saisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->priceTypeRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConfigBoatPriceRequest  $request
     * @param ConfigBoatPrice $boatPrice
     * @return Response
     */
    public function update(ConfigBoatPriceRequest $request, ConfigBoatPrice $boatPrice)
    {
        try {
            $boatPrice->update($request->validated());
            return redirect()->route('admin._config.boatPrices.index')->with('success', 'Bootpreis erfolgreich bearbeitet!');
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
    public function destroy(ConfigBoatPrice $boatPrice)
    {
        try {
            $boatPrice->delete();
            return redirect()->route('admin._config.boatPrices.index')->with('success', 'Bootpreis erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

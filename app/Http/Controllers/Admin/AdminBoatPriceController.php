<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoatPrice;
use App\Http\Requests\BoatPriceRequest;
use Illuminate\Http\Response;

class AdminBoatPriceController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = BoatPrice::paginate($this->paginatorLimit);
        return view('admin.boatPrices.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param BoatPrice $boatPrice
     * @return Response
     */
    public function show(BoatPrice $boatPrice)
    {
        return view('admin.boatPrices.show', compact('boatPrice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.boatPrices.create', [
            'optionsSaisonDates' => $this->saisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->priceTypeRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BoatPriceRequest  $request
     * @return Response
     */
    public function store(BoatPriceRequest $request)
    {
        try {
            BoatPrice::create($request->validated());
            return redirect()->route('admin.boatPrices.index')->with('success', 'Bootpreis erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BoatPrice $boatPrice
     * @return Response
     */
    public function edit(BoatPrice $boatPrice)
    {
        return view('admin.boatPrices.edit', [
            'boatPrice' => $boatPrice,
            'optionsSaisonDates' => $this->saisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->priceTypeRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BoatPriceRequest  $request
     * @param BoatPrice $boatPrice
     * @return Response
     */
    public function update(BoatPriceRequest $request, BoatPrice $boatPrice)
    {
        try {
            $boatPrice->update($request->validated());
            return redirect()->route('admin.boatPrices.index')->with('success', 'Bootpreis erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BoatPrice $boatPrice
     * @return Response
     */
    public function destroy(BoatPrice $boatPrice)
    {
        try {
            $boatPrice->delete();
            return redirect()->route('admin.boatPrices.index')->with('success', 'Bootpreis erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

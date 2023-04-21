<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigOffer;
use Illuminate\Http\Request;
use App\Http\Requests\ConfigOfferRequest;
use App\Traits\Controller\HasToggle;
use Illuminate\Http\Response;

class AdminConfigOfferController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigOffer::paginate($this->paginatorLimit);
        return view('admin._config.offers.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigOffer $offer
     * @return Response
     */
    public function show(ConfigOffer $offer)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigOfferRequest  $request
     * @return Response
     */
    public function store(ConfigOfferRequest $request)
    {
        try {
            $validated = $request->validated();
            ConfigOffer::create($validated);
            return redirect()->route('admin._config.offers.index')->with('success', 'Angebot erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigOffer $offer
     * @return Response
     */
    public function edit(ConfigOffer $offer)
    {
        return view('admin._config.offers.edit', compact('offer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConfigOfferRequest  $request
     * @param ConfigOffer $offer
     * @return Response
     */
    public function update(ConfigOfferRequest $request, ConfigOffer $offer)
    {
        try {
            $validated = $request->validated();
            $offer->update($validated);
            return redirect()->route('admin._config.offers.index')->with('success', 'Angebot erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigOffer $offer
     * @return Response
     */
    public function destroy(ConfigOffer $offer)
    {
        try {
            $offer->delete();
            return redirect()->route('admin._config.offers.index')->with('success', 'Angebot erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function toggle(ConfigOffer $offer, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            $offer->update([$attribute => $value]);
            $offer->refresh();
            return response()->json($offer);
        }
        return response()->json(['error' => 'no ajax request']);
    }
}

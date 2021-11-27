<?php
namespace App\Http\Controllers\Admin;

use App\Models\BoatGuest;
use App\Models\BoatGuestDates;
use Illuminate\Http\Response;
use App\Http\Requests\BoatGuestDatesRequest;

class AdminBoatGuestDatesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query      = BoatGuestDates::with('boat')->orderByDesc('from');
        $priceTotal = $query->get()->sum(fn ($item) => $item->price);
        $data       = $query->paginate($this->paginatorLimit);
        return view('admin.boatGuestDates.index', compact('data', 'priceTotal'));
    }

    /**
     * Display the specified resource.
     *
     * @param  BoatGuestDates $boatGuestDates
     * @return Response
     */
    public function show(BoatGuestDates $boatGuestDate)
    {
        return view('admin.boatGuestDates.show'. compact('boatGuestDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $options = $this->boatGuestRepository->options();
        return view(
            'admin.boatGuestDates.create', [
            'boatGuestsOptions' => $options->getSelectOptions(),
            'boatGuestsOptionsAutocomplete' => $options->getSelectOptionsData()->toJson()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BoatGuestDatesRequest $request
     * @return Response
     */
    public function store(BoatGuestDatesRequest $request)
    {
        $validated = $request->validated();
        $boatValidated = collect($validated)->only(['name','length','home_port'])->toArray();
        $boatGestValidated = collect($validated)->except(['name','length','home_port'])->toArray();
        try {
            $boatGuest = BoatGuest::whereName($validated['name'])->first() ?? BoatGuest::create($boatValidated);
            $boatGuest->dates()->create($boatGestValidated);
            return redirect()->route('admin.boatGuestDates.index')->with('success', 'Gastboot Buchung erfolgreich angelegt!');
        } catch(Exception $e) {
            die($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  BoatGuestDates $boatGuestDate
     * @return Response
     */
    public function edit(BoatGuestDates $boatGuestDate)
    {
        $options = $this->boatGuestRepository->options();
        return view(
            'admin.boatGuestDates.edit', [
            'boatGuestDate'     => $boatGuestDate,
            'boatGuestsOptions' => $options->getSelectOptions(),
            'boatGuestsOptionsAutocomplete' => $options->getSelectOptionsData()->toJson()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BoatGuestDatesRequest $request
     * @param  BoatGuestDates        $boatGuestDate
     * @return Response
     */
    public function update(BoatGuestDatesRequest $request, BoatGuestDates $boatGuestDate)
    {
        $validated  = $request->validated();
        $boatValidated = collect($validated)->only(['name','length','home_port'])->toArray();
        $boatGestValidated = collect($validated)->except(['name','length','home_port'])->toArray();
        try {
            $boatGuestDate->boat()->update($boatValidated);
            $boatGuestDate->update($boatGestValidated);
            return redirect()->route('admin.boatGuestDates.index')->with('success', 'Gastboot Buchung erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatGuestDates.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  BoatGuestDates $boatGuestDate
     * @return Response
     */
    public function destroy(BoatGuestDates $boatGuestDate)
    {
        try {
            $boatGuestDate->delete();
            return redirect()->route('admin.boatGuestDates.index')->with('success', 'Gastboot Buchung erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatGuestDates.index')->with('error', $e->getMessage());
        }
    }
}

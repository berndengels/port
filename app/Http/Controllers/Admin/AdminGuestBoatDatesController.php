<?php
namespace App\Http\Controllers\Admin;

use App\Models\GuestBoat;
use App\Models\GuestBoatDates;
use Illuminate\Http\Response;
use App\Http\Requests\GuestBoatDatesRequest;

class AdminGuestBoatDatesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $query      = GuestBoatDates::with('boat')->orderByDesc('from');
        $priceTotal = $query->get()->sum(fn ($item) => $item->price);
        $data       = $query->paginate($this->paginatorLimit);
        return view('admin.guestBoatDates.index', compact('data', 'priceTotal'));
    }

    /**
     * Display the specified resource.
     *
     * @param  GuestBoatDates $boatGuestDates
     * @return Response
     */
    public function show(GuestBoatDates $guestBoatDate)
    {
        return view('admin.guestBoatDates.show'. compact('guestBoatDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $options = $this->guestBoatRepository->options();
        return view(
            'admin.guestBoatDates.create', [
//            'guestBoatOptions' => $options->getSelectOptions(),
            'guestBoatOptionsAutocomplete' => $options->getSelectOptionsData()->toJson()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GuestBoatDatesRequest $request
     * @return Response
     */
    public function store(GuestBoatDatesRequest $request)
    {
        $validated = $request->validated();
        $boatValidated = collect($validated)->only(['name','length','home_port'])->toArray();
        $boatGestValidated = collect($validated)->except(['name','length','home_port'])->toArray();
        try {
            $boatGuest = GuestBoat::whereName($validated['name'])->first() ?? GuestBoat::create($boatValidated);
            $boatGuest->dates()->create($boatGestValidated);
            return redirect()->route('admin.guestBoatDates.index')->with('success', 'Gastboot Buchung erfolgreich angelegt!');
        } catch(Exception $e) {
            die($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  GuestBoatDates $guestBoatDate
     * @return Response
     */
    public function edit(GuestBoatDates $guestBoatDate)
    {
        dd($guestBoatDate->dailyPrices()->get()->toArray());
        $options = $this->guestBoatRepository->options();
        return view(
            'admin.guestBoatDates.edit', [
                'guestBoatDate'     => $guestBoatDate,
//                'guestBoatOptions' => $options->getSelectOptions(),
                'guestBoatOptionsAutocomplete' => $options->getSelectOptionsData()->toJson()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GuestBoatDatesRequest $request
     * @param  GuestBoatDates        $boatGuestDate
     * @return Response
     */
    public function update(GuestBoatDatesRequest $request, GuestBoatDates $guestBoatDate)
    {
        $validated  = $request->validated();
        $boatValidated = collect($validated)->only(['name','length','home_port'])->toArray();
        $gestBoatValidated = collect($validated)->except(['name','length','home_port'])->toArray();
        try {
            $guestBoatDate->boat()->update($boatValidated);
            $guestBoatDate->update($gestBoatValidated);
            return redirect()->route('admin.guestBoatDates.index')->with('success', 'Gastboot Buchung erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoatDates.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  GuestBoatDates $guestBoatDate
     * @return Response
     */
    public function destroy(GuestBoatDates $guestBoatDate)
    {
        try {
            $guestBoatDate->delete();
            return redirect()->route('admin.guestBoatDates.index')->with('success', 'Gastboot Buchung erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoatDates.index')->with('error', $e->getMessage());
        }
    }
}

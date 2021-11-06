<?php
namespace App\Http\Controllers\Admin;

use App\Models\BoatGuest;
use Illuminate\Http\Response;
use App\Http\Requests\BoatGuestRequest;
use Illuminate\Support\Facades\DB;

class AdminBoatGuestController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = BoatGuest::paginate($this->paginatorLimit);
        return view('admin.boatGuests.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  BoatGuest $boatGuest
     * @return Response
     */
    public function show(BoatGuest $boatGuest)
    {
        return view('admin.boatGuests.show', compact('boatGuest'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.boatGuests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BoatGuestRequest $request
     * @return Response
     */
    public function store(BoatGuestRequest $request)
    {
        $validated  = $request->validated();
        try {
            BoatGuest::create($validated);
            return redirect()->route('admin.boatGuests.index')->with('success', 'Gastboot erfogreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatGuests.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  BoatGuest $boatGuest
     * @return Response
     */
    public function edit(BoatGuest $boatGuest)
    {
        return view('admin.boatGuests.edit', compact('boatGuest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BoatGuestRequest $request
     * @param  BoatGuest        $boatGuest
     * @return Response
     */
    public function update(BoatGuestRequest $request, BoatGuest $boatGuest)
    {
        $validated  = $request->validated();
        try {
            $boatGuest->update($validated);
            return redirect()->route('admin.boatGuests.index')->with('success', 'Gastboot erfogreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatGuests.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  BoatGuest $boatGuest
     * @return Response
     */
    public function destroy(BoatGuest $boatGuest)
    {
        try {
            $boatGuest->delete();
            return redirect()->route('admin.boatGuests.index')->with('success', 'Gastboot erfogreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatGuests.index')->with('error', $e->getMessage());
        }
    }
}

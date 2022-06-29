<?php

namespace App\Http\Controllers\Admin;

use App\Models\GuestBoatBerth;
use App\Http\Requests\StoreGuestBoatBerthRequest;
use App\Http\Requests\UpdateGuestBoatBerthRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminGuestBoatBerthController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = GuestBoatBerth::orderBy('number')->get();
        $data = json_encode($data);
        return view('admin.guestBoatBerths.vue-index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param GuestBoatBerth $guestBoatBerth
     * @return Response
     */
    public function show(GuestBoatBerth $guestBoatBerth)
    {
        return view('admin.guestBoatBerths.show', compact('guestBoatBerth'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.guestBoatBerths.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreGuestBoatBerthRequest  $request
     * @return Response
     */
    public function store(StoreGuestBoatBerthRequest $request)
    {
        try {
            GuestBoatBerth::create($request->validated());
            return redirect()->route('admin.guestBoatBerths.index')->with('success', 'Liegeplatz erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoatBerths.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GuestBoatBerth $guestBoatBerth
     * @return Response
     */
    public function edit(GuestBoatBerth $guestBoatBerth)
    {
        return view('admin.guestBoatBerths.edit', compact('guestBoatBerth'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateGuestBoatBerthRequest  $request
     * @param GuestBoatBerth $guestBoatBerth
     * @return Response
     */
    public function update(UpdateGuestBoatBerthRequest $request, GuestBoatBerth $guestBoatBerth)
    {
        try {
            $guestBoatBerth->update($request->validated());
            return redirect()->route('admin.guestBoatBerths.index')->with('success', 'Liegeplatz erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoatBerths.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param GuestBoatBerth $guestBoatBerth
     * @return Response
     */
    public function destroy(GuestBoatBerth $guestBoatBerth)
    {
        try {
            $guestBoatBerth->delete();
            return redirect()->route('admin.guestBoatBerths.index')->with('success', 'Liegeplatz erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoatBerths.index')->with('error', $e->getMessage());
        }
    }

    public function toggle(GuestBoatBerth $guestBoatBerth, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            $guestBoatBerth->update([$attribute => $value]);
            $guestBoatBerth->refresh();
            return response()->json($guestBoatBerth);
        }
        return response()->json(['error' => 'no ajax request']);
    }

}

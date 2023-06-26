<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GuestBoatResource;
use App\Models\GuestBoat;
use Illuminate\Http\Request;

class ApiGuestBoatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GuestBoat  $guestBoat
     * @return \Illuminate\Http\Response
     */
    public function show(GuestBoat $guestBoat)
    {
		$guestBoat = new GuestBoatResource($guestBoat);
		return response()->json($guestBoat);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GuestBoat  $guestBoat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GuestBoat $guestBoat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GuestBoat  $guestBoat
     * @return \Illuminate\Http\Response
     */
    public function destroy(GuestBoat $guestBoat)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\BoatGuestDates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;

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
        return view('admin.boatGuestDates.index', compact('data','priceTotal'));
    }

    /**
     * Display the specified resource.
     *
     * @param BoatGuestDates $boatGuestDates
     * @return Response
     */
    public function show(BoatGuestDates $boatGuestDates)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BoatGuestDates $boatGuestDates
     * @return Response
     */
    public function edit(BoatGuestDates $boatGuestDates)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param BoatGuestDates $boatGuestDates
     * @return Response
     */
    public function update(Request $request, BoatGuestDates $boatGuestDates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BoatGuestDates $boatGuestDates
     * @return Response
     */
    public function destroy(BoatGuestDates $boatGuestDates)
    {
        //
    }
}

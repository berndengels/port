<?php

namespace App\Http\Controllers\Admin;

use App\Models\SaisonDates;
use Illuminate\Http\Response;
use App\Http\Requests\SaisonDatesRequest;

class AdminSaisonDatesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = SaisonDates::paginate($this->paginatorLimit);
        return view('admin.saisonDates.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  SaisonDates  $saisonDate
     * @return Response
     */
    public function show(SaisonDates $saisonDate)
    {
        return view('admin.saisonDates.show', compact('saisonDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.saisonDates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SaisonDatesRequest  $request
     * @return Response
     */
    public function store(SaisonDatesRequest $request)
    {
        try {
            SaisonDates::create($request->validated());
            return redirect()->route('admin.saisonDates.index')->with('success', 'Saison erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  SaisonDates  $saisonDate
     * @return Response
     */
    public function edit(SaisonDates $saisonDate)
    {
        return view('admin.saisonDates.edit', compact('saisonDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SaisonDatesRequest  $request
     * @param  SaisonDates  $saisonDate
     * @return Response
     */
    public function update(SaisonDatesRequest $request, SaisonDates $saisonDate)
    {
        try {
            $saisonDate->update($request->validated());
            return redirect()->route('admin.saisonDates.index')->with('success', 'Saison erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  SaisonDates  $saisonDate
     * @return Response
     */
    public function destroy(SaisonDates $saisonDate)
    {
        try {
            $saisonDate->delete();
            return redirect()->route('admin.saisonDates.index')->with('success', 'Saison erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

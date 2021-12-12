<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigSaisonDates;
use Illuminate\Http\Response;
use App\Http\Requests\ConfigSaisonDatesRequest;

class AdminConfigSaisonDatesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigSaisonDates::paginate($this->paginatorLimit);
        return view('admin._config.saisonDates.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  ConfigSaisonDates  $saisonDate
     * @return Response
     */
    public function show(ConfigSaisonDates $saisonDate)
    {
        return view('admin._config.saisonDates.show', compact('saisonDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.saisonDates.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigSaisonDatesRequest  $request
     * @return Response
     */
    public function store(ConfigSaisonDatesRequest $request)
    {
        try {
            ConfigSaisonDates::create($request->validated());
            return redirect()->route('admin.config.saisonDates.index')->with('success', 'Saison erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ConfigSaisonDates  $saisonDate
     * @return Response
     */
    public function edit(ConfigSaisonDates $saisonDate)
    {
        return view('admin._config.saisonDates.edit', compact('saisonDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConfigSaisonDatesRequest  $request
     * @param  ConfigSaisonDates  $saisonDate
     * @return Response
     */
    public function update(ConfigSaisonDatesRequest $request, ConfigSaisonDates $saisonDate)
    {
        try {
            $saisonDate->update($request->validated());
            return redirect()->route('admin.config.saisonDates.index')->with('success', 'Saison erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ConfigSaisonDates  $saisonDate
     * @return Response
     */
    public function destroy(ConfigSaisonDates $saisonDate)
    {
        try {
            $saisonDate->delete();
            return redirect()->route('admin.config.saisonDates.index')->with('success', 'Saison erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

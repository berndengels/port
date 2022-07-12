<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreConfigPortRequest;
use App\Http\Requests\UpdateConfigPortRequest;
use App\Models\ConfigPort;
use Illuminate\Http\Response;

class AdminConfigPortController extends AdminController
{
    /**
     * Display the specified resource.
     *
     * @param ConfigPort $configPort
     * @return Response
     */
    public function index()
    {
        $data = ConfigPort::firstOrFail();
        return view('admin._config.port.show', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.port.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreConfigPortRequest  $request
     * @return Response
     */
    public function store(StoreConfigPortRequest $request)
    {
        try {
            $configPort = ConfigPort::create($request->validated());
            return redirect()->route('admin.config.port.index', $configPort)->with('success', 'Portdaten erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigPort $configPort
     * @return Response
     */
    public function edit(ConfigPort $port)
    {
        return view('admin._config.port.edit', compact('port'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateConfigPortRequest  $request
     * @param ConfigPort $configPort
     * @return Response
     */
    public function update(UpdateConfigPortRequest $request, ConfigPort $port)
    {
        try {
            $port->update($request->validated());
            return redirect()->route('admin.config.port.index')->with('success', 'Portdaten erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigPort $configPort
     * @return Response
     */
    public function destroy(ConfigPort $port)
    {
        try {
            $port->delete();
            return redirect()->route('admin.config.port.index')->with('success', 'Portdaten erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

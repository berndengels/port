<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConfigServices;
use App\Http\Requests\UpdateConfigServices;

class AdminConfigServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ConfigService::paginate($this->paginatorLimit);
        return view('admin._config.services.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConfigService  $configService
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigService $service)
    {
        return view('admin._config.services.show', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin._config.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreConfigServices  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConfigServices $request)
    {
        try {
            ConfigService::create($request->validated());
            return redirect()->route('admin.config.services.index')->with('success', 'Service erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.config.services.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConfigService  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigService $service)
    {
        return view('admin._config.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateConfigServices  $request
     * @param  \App\Models\ConfigService  $configService
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConfigServices $request, ConfigService $service)
    {
        try {
            $service->update($request->validated());
            return redirect()->route('admin.config.services.index')->with('success', 'Service erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.config.services.edit', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConfigService  $configService
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfigService $service)
    {
        try {
            $service->delete();
            return redirect()->route('admin.config.services.index')->with('success', 'Service erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigSetting;
use Illuminate\Http\Response;
use App\Http\Requests\StoreConfigSettingsRequest;
use App\Http\Requests\UpdateConfigSettingsRequest;

class AdminConfigSettingsController extends AdminController
{
    /**
     * Display the specified resource.
     *
     * @param ConfigSetting $configPort
     * @return Response
     */
    public function index()
    {
        $data = ConfigSetting::first();
        if(!$data) {
            return $this->create();
        }
        return view('admin._config.settings.show', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if(ConfigSetting::first()) {
            return redirect()->route('admin.configSettings.index')->with('error', 'Daten wurden bereits angelegt!');
        }
        return view('admin._config.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreConfigSettingsRequest  $request
     * @return Response
     */
    public function store(StoreConfigSettingsRequest $request)
    {
        try {
            ConfigSetting::create($request->validated());
            return redirect()->route('admin.configSettings.index')->with('success', 'Daten erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigSetting $configSetting
     * @return Response
     */
    public function edit(ConfigSetting $configSetting)
    {
        return view('admin._config.settings.edit', compact('configSetting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateConfigSettingsRequest  $request
     * @param ConfigSetting $configSetting
     * @return Response
     */
    public function update(UpdateConfigSettingsRequest $request, ConfigSetting $configSetting)
    {
        try {
			$configSetting->update($request->validated());
            return redirect()->route('admin.configSettings.index')->with('success', 'Daten erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigSetting $configSetting
     * @return Response
     */
    public function destroy(ConfigSetting $configSetting)
    {
        try {
			$configSetting->delete();
            return redirect()->route('admin.configSettings.index')->with('success', 'Daten erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

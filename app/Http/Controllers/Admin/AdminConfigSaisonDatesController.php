<?php

namespace App\Http\Controllers\Admin;

use App\Models\ConfigSaisonDates;
use Illuminate\Http\Response;
use App\Http\Requests\ConfigSaisonDatesRequest;
use Illuminate\Support\Str;

class AdminConfigSaisonDatesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        session()->remove('from');
        $data = ConfigSaisonDates::paginate($this->paginatorLimit);
        return view('admin._config.saisonDates.index', compact('data'));
    }

    public function guests()
    {
        $key = 'guest';
        session()->put('from',$key);
        $data = ConfigSaisonDates::where('key','=',$key)->paginate($this->paginatorLimit);
        return view('admin._config.saisonDates.index', compact('data','key'));
    }

    public function customers()
    {
        $key = 'customer';
        session()->put('from',$key);
        $data = ConfigSaisonDates::where('key','=',$key)->paginate($this->paginatorLimit);
        return view('admin._config.saisonDates.index', compact('data','key'));
    }

    /**
     * Display the specified resource.
     *
     * @param  ConfigSaisonDates  $saisonDate
     * @return Response
     */
    public function show(ConfigSaisonDates $saisonDate)
    {
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        return view('admin._config.saisonDates.show', compact('saisonDate', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        return view('admin._config.saisonDates.create', compact('route'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigSaisonDatesRequest  $request
     * @return Response
     */
    public function store(ConfigSaisonDatesRequest $request)
    {
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        try {
            ConfigSaisonDates::create($request->validated());
            return redirect()->route('admin.config-saisonDates.'.$route)->with('success', 'Saison erfolgreich angelegt!');
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
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        return view('admin._config.saisonDates.edit', compact('saisonDate','route'));
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
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        try {
            $saisonDate->update($request->validated());
            return redirect()->route('admin.config-saisonDates.'.$route)->with('success', 'Saison erfolgreich bearbeitet!');
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
        $from = session()->get('from');
        $route = $from ? Str::plural($from) : 'index';
        try {
            $saisonDate->delete();
            return redirect()->route('admin.config-saisonDates.'.$route)->with('success', 'Saison erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

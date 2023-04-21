<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Response;
use App\Models\ConfigSaisonRent;
use App\Http\Requests\ConfigSaisonRentRequest;

/**
 * @todo price calculation for saisons vie dates
 */
class AdminConfigSaisonRentController extends AdminController
{
    private $yearsOptions;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigSaisonRent::paginate($this->paginatorLimit);
        return view('admin._config.saisonRents.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigSaisonRent $configSaisonRent
     * @return Response
     */
    public function show(ConfigSaisonRent $configSaisonRent) {
        return view('admin._config.saisonRents.show', compact('configSaisonRent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.saisonRents.create', [
            'yearsOptions'  => $this->yearsOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConfigSaisonRentRequest $request
     * @return Response
     */
    public function store(ConfigSaisonRentRequest $request)
    {
        try {
            ConfigSaisonRent::create($request->validated());
            return redirect()->route('admin.config.saisonRents.index')->with('success', 'Rent erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.config.saisonRents.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigSaisonRent $saisonRent
     * @return Response
     */
    public function edit(ConfigSaisonRent $saisonRent)
    {
        return view('admin._config.saisonRents.edit', compact('saisonRent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConfigSaisonRentRequest $request
     * @param ConfigSaisonRent $configSaisonRent
     * @return Response
     */
    public function update(ConfigSaisonRentRequest $request, ConfigSaisonRent $configSaisonRent)
    {
        try {
            $configSaisonRent->update($request->validated());
            return redirect()->route('admin.config.saisonRents.index')->with('success', 'Rent erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.config.saisonRents.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigSaisonRent $configSaisonRent
     * @return Response
     */
    public function destroy(ConfigSaisonRent $configSaisonRent)
    {
        try {
            $configSaisonRent->delete();
            return redirect()->route('admin.config.saisonRents.index')->with('success', 'Rent erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

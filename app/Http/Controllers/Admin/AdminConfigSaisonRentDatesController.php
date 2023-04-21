<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreConfigSaisonRentDatesRequest;
use App\Http\Requests\UpdateConfigSaisonRentDatesRequest;
use App\Models\ConfigSaisonRentDates;
use App\Http\Requests\ConfigSaisonRentDatesRequest;
use Illuminate\Http\Response;

class AdminConfigSaisonRentDatesController extends AdminController
{
    protected $saisonRents;
    protected $holidayOptions;

    public function __construct()
    {
        parent::__construct();
        $this->saisonRents = $this->configSaisonRentRepository->options()->getSelectOptions()
            ->prepend('Saison wählen', null);
        $this->holidayOptions = collect($this->configHolidayRepository
            ->getHolidayOptions())
            ->prepend('Feiertage wählen', null);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigSaisonRentDates::paginate($this->paginatorLimit);
        return view('admin._config.saisonRentDates.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigSaisonRentDates $configSaisonRentDate
     * @return Response
     */
    public function show(ConfigSaisonRentDates $configSaisonRentDate)
    {
        return view('admin._config.saisonRentDates.show', compact('configSaisonRentDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.saisonRentDates.create', [
            'saisonRents' => $this->saisonRents,
            'holidayOptions' => $this->holidayOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreConfigSaisonRentDatesRequest  $request
     * @return Response
     */
    public function store(StoreConfigSaisonRentDatesRequest $request)
    {
        try {
            ConfigSaisonRentDates::create($request->validated());
            return redirect()->route('admin.config.saisonRentDates.index')->with('success', 'Rent Date erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.config.saisonRentDates.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigSaisonRentDates $configSaisonRentDate
     * @return Response
     */
    public function edit(ConfigSaisonRentDates $saisonRentDate)
    {
        return view('admin._config.saisonRentDates.edit', [
            'saisonRentDate'    => $saisonRentDate,
            'saisonRents'       => $this->saisonRents,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateConfigSaisonRentDatesRequest  $request
     * @param ConfigSaisonRentDates $configSaisonRentDate
     * @return Response
     */
    public function update(UpdateConfigSaisonRentDatesRequest $request, ConfigSaisonRentDates $saisonRentDate)
    {
        try {
            $saisonRentDate->update($request->validated());
            return redirect()->route('admin.config.saisonRentDates.index')->with('success', 'Rent Date erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.config.saisonRentDates.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigSaisonRentDates $configSaisonRentDate
     * @return Response
     */
    public function destroy(ConfigSaisonRentDates $saisonRentDate)
    {
        try {
            $saisonRentDate->delete();
            return redirect()->route('admin.config.saisonRentDates.index')->with('success', 'Rent Date erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ModelHelper;
use App\Models\ConfigDailyPrice;
use App\Http\Requests\ConfigDailyPriceRequest;
use App\Traits\Models\HasDailyPrice;
use Illuminate\Http\Response;
use ReflectionClass;

class AdminConfigDailyPriceController extends AdminController
{
    protected $optionsModel;

    public function __construct()
    {
        parent::__construct();
        $trait = HasDailyPrice::class;
        $this->optionsModel = ModelHelper::allModels()->filter(fn ($class) =>
            collect((new ReflectionClass($class))->getTraits())->filter(fn($t) => $t->name === $trait)->count() > 0
        )->map(fn($c) => ltrim($c,"\\"))->flip();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = ConfigDailyPrice::paginate($this->paginatorLimit);
        return view('admin._config.dailyPrices.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param ConfigDailyPrice $dailyPrice
     * @return Response
     */
    public function show(ConfigDailyPrice $dailyPrice)
    {
        return view('admin._config.dailyPrices.show', compact('dailyPrice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin._config.dailyPrices.create', [
            'optionsModel'  => $this->optionsModel,
            'optionsSaisonDates' => $this->configSaisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->configPriceTypeRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ConfigDailyPriceRequest  $request
     * @return Response
     */
    public function store(ConfigDailyPriceRequest $request)
    {
        try {
            ConfigDailyPrice::create($request->validated());
            return redirect()->route('admin.config.dailyPrices.index')->with('success', 'Tagespreis erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ConfigDailyPrice $dailyPrice
     * @return Response
     */
    public function edit(ConfigDailyPrice $dailyPrice)
    {
        return view('admin._config.dailyPrices.edit', [
            'dailyPrice' => $dailyPrice,
            'optionsModel'  => $this->optionsModel,
            'optionsSaisonDates' => $this->configSaisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->configPriceTypeRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ConfigDailyPriceRequest  $request
     * @param ConfigDailyPrice $dailyPrice
     * @return Response
     */
    public function update(ConfigDailyPriceRequest $request, ConfigDailyPrice $dailyPrice)
    {
        try {
            $dailyPrice->update($request->validated());
            return redirect()->route('admin.config.dailyPrices.index')->with('success', 'Tagespreis erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ConfigDailyPrice $dailyPrice
     * @return Response
     */
    public function destroy(ConfigDailyPrice $dailyPrice)
    {
        try {
            $dailyPrice->delete();
            return redirect()->route('admin.config.dailyPrices.index')->with('success', 'Tagespreis erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

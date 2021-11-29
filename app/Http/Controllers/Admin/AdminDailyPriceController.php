<?php

namespace App\Http\Controllers\Admin;

use App\Helper\ModelHelper;
use App\Models\DailyPrice;
use App\Http\Requests\DailyPriceRequest;
use App\Traits\Models\HasDailyPrice;
use Illuminate\Http\Response;
use ReflectionClass;

class AdminDailyPriceController extends AdminController
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
        $data = DailyPrice::paginate($this->paginatorLimit);
        return view('admin.dailyPrices.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param DailyPrice $dailyPrice
     * @return Response
     */
    public function show(DailyPrice $dailyPrice)
    {
        return view('admin.dailyPrices.show', compact('dailyPrice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.dailyPrices.create', [
            'optionsModel'  => $this->optionsModel,
            'optionsSaisonDates' => $this->saisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->priceTypeRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DailyPriceRequest  $request
     * @return Response
     */
    public function store(DailyPriceRequest $request)
    {
        try {
            DailyPrice::create($request->validated());
            return redirect()->route('admin.dailyPrices.index')->with('success', 'Tagespreis erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DailyPrice $dailyPrice
     * @return Response
     */
    public function edit(DailyPrice $dailyPrice)
    {
        return view('admin.dailyPrices.edit', [
            'dailyPrice' => $dailyPrice,
            'optionsModel'  => $this->optionsModel,
            'optionsSaisonDates' => $this->saisonDatesRepository->options()->getSelectOptions(),
            'optionsPriceTypes' => $this->priceTypeRepository->options()->getSelectOptions(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DailyPriceRequest  $request
     * @param DailyPrice $dailyPrice
     * @return Response
     */
    public function update(DailyPriceRequest $request, DailyPrice $dailyPrice)
    {
        try {
            $dailyPrice->update($request->validated());
            return redirect()->route('admin.dailyPrices.index')->with('success', 'Tagespreis erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DailyPrice $dailyPrice
     * @return Response
     */
    public function destroy(DailyPrice $dailyPrice)
    {
        try {
            $dailyPrice->delete();
            return redirect()->route('admin.dailyPrices.index')->with('success', 'Tagespreis erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

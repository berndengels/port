<?php

namespace App\Http\Controllers\Admin;

use Acaronlex\LaravelCalendar\Calendar;
use App\Http\Requests\CaravanDatesValidationData;
use App\Http\Requests\HouseboatDatesRequest;
use App\Http\Requests\HouseboatDatesValidationData;
use App\Models\Houseboat;
use App\Models\HouseboatDates;
use App\Repositories\CalendarRepository;
use App\Rules\CaravanDatesIntervalUnique;
use App\Rules\HouseboatDatesIntervalUnique;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AdminHouseboatDatesController extends AdminController
{
    private $years;
    private $monthsByYear;
    private $houseboatOptions;
    private $customerOptions;
    private $calendarDates;
    /**
     * @var HouseboatDates[]|Collection|\Illuminate\Support\Collection
     */
    private $dates;

    public function __construct()
    {
        parent::__construct();
        $this->monthsByYear = HouseboatDates::getMonthsByYears();
        $this->years = array_keys($this->monthsByYear);
        $this->houseboatOptions = $this->houseboatRepository
            ->options()
            ->getSelectOptions()
            ->prepend('Hausboot wählen', null);

        $this->customerOptions = $this->customerRepository
            ->options(where: ['customer_type' => 'houseboat'])
            ->getSelectOptions()
            ->prepend('Kunde wählen', null);
        $this->dates = HouseboatDates::orderBy('from')->get();
        $this->calendarDates = (new CalendarRepository('houseboat', $this->dates))->getJsonDates();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $houseboat  = $request->input('houseboat');
        $year       = $request->input('year');
        $month      = $request->input('month');

        if($year || $month) {
            $houseboat = null;
        }

        if($houseboat) {
            $year = null;
            $month = null;
        }

        /**
         * @var $query Builder
         */
        $query = HouseboatDates::with(['houseboat','customer'])
            ->orderByDesc('from');

        $yearOptions = HouseboatDates::yearOptions();
        $monthOptions = HouseboatDates::monthOptions();

        $data = $query
            ->houseboatByDates($houseboat)
            ->fromYearMonth($year, $month);

        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(fn ($item) => $item->price);

        $this->dates = $data->get();
        $this->calendarDates = (new CalendarRepository('houseboat', $this->dates))->getJsonDates();

        $paginated = $data->paginate($this->paginatorLimit);
        $queryString = $request->only(['houseboat','year', 'month']);

        return view(
            'admin.houseboatDates.index', [
                'calendarDates'     => $this->calendarDates,
                'initialDate'       => $this->dates->first()->from->format('Y-m-d'),
                'houseboat'         => $houseboat,
                'data'              => $paginated,
                'years'             => $this->years,
                'monthsByYear'      => $this->monthsByYear,
                'houseboatOptions'  => $this->houseboatOptions,
                'yearOptions'       => $yearOptions,
                'monthOptions'      => $monthOptions,
                'priceTotal'        => $priceTotal,
                'year'              => $year,
                'month'             => $month,
                'queryString'       => $queryString,
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param HouseboatDates $houseboatDate
     * @return Response
     */
    public function show(HouseboatDates $houseboatDate)
    {
        $prices         = json_decode($houseboatDate->prices);
        $days           = $prices->days;
        $dailyPrices    = $prices->dailyPrices;
        $basePrice      = $prices->priceBase;
        $priceTotal     = $prices->total;

        return view('admin.houseboatDates.show', compact('houseboatDate','days', 'dailyPrices','basePrice', 'priceTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.houseboatDates.create', [
            'calendarDates'     => $this->calendarDates,
            'initialDate'       => $this->dates->first()->from->format('Y-m-d'),
            'customerOptions'   => $this->customerOptions,
            'houseboatOptions'  => $this->houseboatOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HouseboatDatesRequest $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $houseboatId    = $request->post('houseboat_id');
            $houseboat      = Houseboat::find($houseboatId);
            $validationData = new HouseboatDatesValidationData($request);
            $request        = $validationData->getRequest();

            $rules  = $validationData->rules();
            $rules['until']  = array_merge($rules['until'], [new HouseboatDatesIntervalUnique($houseboat)]);

            $validator  = Validator::make($request->all(), $rules, $validationData->messages());
            $validator->validate();

            $houseboatDate = $houseboat->dates()->create($validator->validated());

            return redirect()->route('admin.houseboatDates.show', $houseboatDate)->with('success', 'Hausboot Buchung erfolgreich angelegt!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HouseboatDates $houseboatDate
     * @return Response
     */
    public function edit(HouseboatDates $houseboatDate)
    {
        $this->dates = HouseboatDates::whereHouseboatId($houseboatDate->houseboat->id)
            ->orderBy('from', 'desc')
            ->get();
        $this->calendarDates = (new CalendarRepository('houseboat', $this->dates))->getJsonDates();

        return view('admin.houseboatDates.edit', [
            'calendarDates'     => $this->calendarDates,
            'initialDate'       => $houseboatDate->from,
            'customerOptions'   => $this->customerOptions,
            'houseboatDate'     => $houseboatDate,
            'houseboatOptions'  => $this->houseboatOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param HouseboatDatesRequest $request
     * @param HouseboatDates $houseboatDate
     * @return Response
     */
    public function update(HouseboatDatesRequest $request, HouseboatDates $houseboatDate)
    {
        try {
            $houseboatDate->update($request->validated());
            return redirect()->route('admin.houseboatDates.index')->with('success', 'Hausboot Buchung erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HouseboatDates $houseboatDate
     * @return Response
     */
    public function destroy(HouseboatDates $houseboatDate)
    {
        try {
            $houseboatDate->delete();
            return redirect()->route('admin.houseboatDates.index')->with('success', 'Hausboot Buchung erfolgreich gelöscht!');
        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function printPage(HouseboatDates $houseboatDate)
    {
        $prices         = json_decode($houseboatDate->prices);
        $days           = $prices->days;
        $dailyPrices    = $prices->dailyPrices;
        $basePrice      = $prices->priceBase;
        $priceTotal     = $prices->total;

        return view('admin.houseboatDates.print', compact('houseboatDate','days', 'dailyPrices','basePrice', 'priceTotal'));
    }

    public function sendInvoice(HouseboatDates $houseboatDate)
    {
        return 'work in progress';
    }

    public function toggle(HouseboatDates $houseboatDate, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            $houseboatDate->update([$attribute => $value]);
            $houseboatDate->refresh();
            return response()->json($houseboatDate);
        }
        return response()->json(['error' => 'no ajax request']);
    }
}

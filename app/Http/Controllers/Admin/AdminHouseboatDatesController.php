<?php

namespace App\Http\Controllers\Admin;

use Acaronlex\LaravelCalendar\Calendar;
use App\Http\Requests\HouseboatDatesRequest;
use App\Models\HouseboatDates;
use App\Repositories\CalendarRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminHouseboatDatesController extends AdminController
{
    private $years;
    private $monthsByYear;
    private $houseboatOptions;
    private $customerOptions;
    private $calendar;
    private $calendarOptions = [

    ];
    private $dates;

    public function __construct()
    {
        parent::__construct();
        $this->monthsByYear = HouseboatDates::getMonthsByYears();
        $this->years = array_keys($this->monthsByYear);
        $this->houseboatOptions = $this->houseboatRepository->options()->getSelectOptions();
        $this->customerOptions = $this->customerRepository
            ->options(where: ['customer_type' => 'houseboat'])
            ->getSelectOptions();
        $this->dates = HouseboatDates::orderBy('from')->get();

        if($this->dates && $this->dates->count() > 0) {
            $this->calendar = (new CalendarRepository('houseboat', $this->dates))->getCalendar();
        }
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

        $paginated = $data->paginate($this->paginatorLimit);
        $queryString = $request->only(['houseboat','year', 'month']);

        return view(
            'admin.houseboatDates.index', [
                'calendar'          => $this->calendar,
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.houseboatDates.create', [
            'calendar'  => $this->calendar,
            'customerOptions'  => $this->customerOptions,
            'houseboatOptions'  => $this->houseboatOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param HouseboatDatesRequest $request
     * @return Response
     */
    public function store(HouseboatDatesRequest $request)
    {
        try {
            HouseboatDates::create($request->validated());
            return redirect()->route('admin.houseboatDates.index')->with('success', 'Hausboot Buchung erfolgreich angelegt!');
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
        $calendar = new Calendar();
        $calendar->addEvent($houseboatDate)->setOptions([
            'initialDate' => $houseboatDate->from,
            'color'       => '#c00',
            'aspectRatio' => 1,
        ]);

        return view('admin.houseboatDates.edit', [
            'calendar'  => $calendar,
            'customerOptions'  => $this->customerOptions,
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
}

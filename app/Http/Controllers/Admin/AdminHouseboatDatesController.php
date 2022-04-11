<?php

namespace App\Http\Controllers\Admin;

use App\Models\HouseboatDates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminHouseboatDatesController extends AdminController
{
    private $years;
    private $monthsByYear;
    private $houseboatOptions;

    public function __construct()
    {
        parent::__construct();
        $this->monthsByYear = HouseboatDates::getMonthsByYears();
        $this->years = array_keys($this->monthsByYear);
        $this->houseboatOptions = $this->houseboatRepository->options()->getSelectOptions();
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
            'houseboatOptions'  => $this->houseboatOptions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HouseboatDates $houseboatDate
     * @return Response
     */
    public function edit(HouseboatDates $houseboatDate)
    {
        return view('admin.houseboatDates.create', [
            'houseboatDate'     => $houseboatDate,
            'houseboatOptions'  => $this->houseboatOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param HouseboatDates $houseboatDates
     * @return Response
     */
    public function update(Request $request, HouseboatDates $houseboatDates)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HouseboatDates $houseboatDates
     * @return Response
     */
    public function destroy(HouseboatDates $houseboatDates)
    {
        //
    }
}

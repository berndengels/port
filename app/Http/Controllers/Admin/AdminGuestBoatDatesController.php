<?php
namespace App\Http\Controllers\Admin;

use Excel;
use App\Mail\SendExcel;
use App\Exports\GuestBoatDatesExport;
use App\Models\GuestBoat;
use App\Models\GuestBoatDates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\GuestBoatDatesRequest;
use Illuminate\Support\Facades\Mail;

class AdminGuestBoatDatesController extends AdminController
{
    public function __construct()
    {
        $this->monthsByYear = GuestBoatDates::getMonthsByYears();
        $this->years = array_keys($this->monthsByYear);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $guestBoatId  = $request->input('guestBoat');
        $year       = $request->input('year');
        $month      = $request->input('month');

        if($year || $month) {
            $guestBoatId = null;
        }

        if($guestBoatId) {
            $year = null;
            $month = null;
        }

        /**
         * @var $query Builder
         */
        $query = GuestBoatDates::with('boat')
            ->orderByDesc('from');

        $yearOptions = GuestBoatDates::yearOptions();
        $monthOptions = GuestBoatDates::monthOptions();

        $data = $query
            ->guestBoatByDates($guestBoatId ?? null)
            ->fromYearMonth($year, $month);


        $priceTotal = $query->get()->sum(fn ($item) => $item->price);
        $paginated  = $data->paginate($this->paginatorLimit);
        $queryString = $request->only(['guestBoat', 'year', 'month']);

        return view('admin.guestBoatDates.index', [
            'data'              => $paginated,
            'priceTotal'        => $priceTotal,
            'guestBoatOptions'  => $this->guestBoatRepository->options()->getSelectOptions(),
            'years'             => $this->years,
            'monthsByYear'      => $this->monthsByYear,
            'yearOptions'       => $yearOptions,
            'monthOptions'      => $monthOptions,
            'priceTotal'        => $priceTotal,
            'guestBoat'         => $guestBoatId,
            'year'              => $year,
            'month'             => $month,
            'queryString'       => $queryString,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  GuestBoatDates $boatGuestDates
     * @return Response
     */
    public function show(GuestBoatDates $guestBoatDate)
    {
        return view('admin.guestBoatDates.show'. compact('guestBoatDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $options = $this->guestBoatRepository->options();
        return view(
            'admin.guestBoatDates.create', [
//            'guestBoatOptions' => $options->getSelectOptions(),
            'guestBoatOptionsAutocomplete' => $options->getSelectOptionsData()->toJson()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GuestBoatDatesRequest $request
     * @return Response
     */
    public function store(GuestBoatDatesRequest $request)
    {
        $validated = $request->validated();
        $boatValidated = collect($validated)->only(['name','length','home_port'])->toArray();
        $boatGestValidated = collect($validated)->except(['name','length','home_port'])->toArray();
        try {
            $boatGuest = GuestBoat::whereName($validated['name'])->first() ?? GuestBoat::create($boatValidated);
            $boatGuest->dates()->create($boatGestValidated);
            return redirect()->route('admin.guestBoatDates.index')->with('success', 'Gastboot Buchung erfolgreich angelegt!');
        } catch(Exception $e) {
            die($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  GuestBoatDates $guestBoatDate
     * @return Response
     */
    public function edit(GuestBoatDates $guestBoatDate)
    {
        $options = $this->guestBoatRepository->options();
        return view(
            'admin.guestBoatDates.edit', [
                'guestBoatDate'     => $guestBoatDate,
//                'guestBoatOptions' => $options->getSelectOptions(),
                'guestBoatOptionsAutocomplete' => $options->getSelectOptionsData()->toJson()
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GuestBoatDatesRequest $request
     * @param  GuestBoatDates        $boatGuestDate
     * @return Response
     */
    public function update(GuestBoatDatesRequest $request, GuestBoatDates $guestBoatDate)
    {
        $validated  = $request->validated();
        $boatValidated = collect($validated)->only(['name','length','home_port'])->toArray();
        $gestBoatValidated = collect($validated)->except(['name','length','home_port'])->toArray();
        try {
            $guestBoatDate->boat()->update($boatValidated);
            $guestBoatDate->update($gestBoatValidated);
            return redirect()->route('admin.guestBoatDates.index')->with('success', 'Gastboot Buchung erfolgreich bearbeitet!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoatDates.create', $request)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  GuestBoatDates $guestBoatDate
     * @return Response
     */
    public function destroy(GuestBoatDates $guestBoatDate)
    {
        try {
            $guestBoatDate->delete();
            return redirect()->route('admin.guestBoatDates.index')->with('success', 'Gastboot Buchung erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.guestBoatDates.index')->with('error', $e->getMessage());
        }
    }

    public function sendExcel(Request $request, $year = null, $month = null)
    {
        $year       = $request->post('year');
        $month      = $request->post('month');
        $now        = Carbon::now()->format('Ymd-Hi');
        $fileName   = $now.'_guest_boat_dates.xls';
        $subject    = 'Gastboote Daten';

        try {
            $export = new GuestBoatDatesExport($year, $month);
            Mail::send(new SendExcel(
                    recipient:  $request->post('email'),
                    export: $export,
                    fileName: $fileName,
                    subject: $subject,
                    year: $year,
                    month: $month
                )
            );
            return redirect()->route('admin.guestBoatDates.index')->with(['success' => 'Excel-Datei erfolgreich versand!']);
        } catch (Exception $e) {
            return redirect()->route('admin.guestBoatDates.index')->with(['error' => 'Excel-Datei konnte nicht versand werden!']);
        }
    }
}

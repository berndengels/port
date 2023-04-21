<?php
namespace App\Http\Controllers\Admin;

use App\Libs\Prices\PriceCalculator;
use App\Mail\GuestBoatInvoiceMail;
use App\Mail\InvoiceMail;
use App\Models\ConfigSetting;
use App\Repositories\BerthRepository;
use Barryvdh\DomPDF\PDF;
use Excel;
use App\Mail\SendExcel;
use App\Exports\GuestBoatDatesExport;
use App\Models\GuestBoat;
use App\Models\GuestBoatDates;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\GuestBoatDatesRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminGuestBoatDatesController extends AdminController
{
    public function __construct()
    {
        $this->monthsByYear = GuestBoatDates::getMonthsByYearsOptions();
        $this->years = array_keys($this->monthsByYear);
        $this->berthOptions = (new BerthRepository())->optionsData()->prepend('bitte wählen', null);
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
        $from   = $request->input('from');
        $until  = $request->input('until');

        if($from) {
            $from = Carbon::make($from);
        }
        if($until) {
            $until = Carbon::make($until);
        }

        if($from || $until) {
            $guestBoatId = null;
        }

        if($guestBoatId) {
            $from = null;
            $until = null;
        }

        /**
         * @var $query Builder
         */
        $query = GuestBoatDates::with('boat','berth')->sortable();

        $firstDate = Carbon::make(GuestBoatDates::min('from'));
        $lastDate = Carbon::make(GuestBoatDates::max('until'));

        if(!$from) {
            $from = $firstDate;
        }
        if(!$until) {
            $until = $lastDate;
        }

        $data = $query
            ->guestBoatById($guestBoatId ?? null)
            ->datesBetween($from, $until)
        ;


        $priceTotal = $query->get()->sum(fn ($item) => $item->price);
        $paginated  = $data->paginate($this->paginatorLimit);
        $queryString = $request->only(['guestBoat', 'from', 'until','sort']);

        return view('admin.guestBoatDates.index', [
            'data'              => $paginated,
            'priceTotal'        => $priceTotal,
            'guestBoatOptions'  => $this->guestBoatRepository->options()->getSelectOptions()->prepend('Bitte wählen', null),
            'priceTotal'        => $priceTotal,
            'guestBoat'         => $guestBoatId,
            'from'              => $from,
            'until'             => $until,
            'firstDate'         => $firstDate,
            'lastDate'          => $lastDate,
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
        $priceData = $guestBoatDate->getPriceDataAttribute();
        return view('admin.guestBoatDates.show', compact('guestBoatDate','priceData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $options = $this->guestBoatRepository->options();
        return view('admin.guestBoatDates.create', [
            'berthOptions'   => $this->berthOptions,
            'berthHasPrice'  => $this->berthHasPrice,
            'guestBoatOptionsAutocomplete' => $options->getSelectOptionsData()->toJson()
        ]);
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
        return view('admin.guestBoatDates.edit', [
            'guestBoatDate'  => $guestBoatDate,
            'berthOptions'   => $this->berthOptions,
            'berthHasPrice'  => $this->berthHasPrice,
            'guestBoatOptionsAutocomplete' => $options->getSelectOptionsData()->toJson()
        ]);
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

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function sendExcel(Request $request)
    {
        $from       = $request->post('from');
        $until      = $request->post('until');
        if($from) {
            $from = Carbon::make($from);
        }
        if($until) {
            $until = Carbon::make($until);
        }
        $strFrom    = $from ? $from->format('d.m.Y') : 'Anfang';
        $strUntil   = $until ? $until->format('d.m.Y') : 'Ende';

        $now        = Carbon::now()->format('Ymd-Hi');
        $fileName   = $now.'_guest_boat_dates.xls';
        $subject    = "Gastboot Umsatz-Daten $strFrom - $strUntil";

        try {
            $export = new GuestBoatDatesExport($from, $until);
            Mail::send(new SendExcel(
                    recipient:  $request->post('email'),
                    export: $export,
                    fileName: $fileName,
                    subject: $subject,
                    dateFrom: $from,
                    dateUntil: $until
                )
            );
            return redirect()->route('admin.guestBoatDates.index')->with(['success' => 'Excel-Datei erfolgreich versand!']);
        } catch (Exception $e) {
            return redirect()->route('admin.guestBoatDates.index')->with(['error' => 'Excel-Datei konnte nicht versand werden!']);
        }
    }

    /**
     * @param GuestBoatDates $guestBoatDate
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function printPage(GuestBoatDates $guestBoatDate)
    {
        $guestBoatDate->load(['berth','boat']);
        $priceData = $guestBoatDate->getPriceDataAttribute();
        return view('admin.guestBoatDates.print', compact('guestBoatDate','priceData'));
    }

    /**
     * @param GuestBoatDates $guestBoatDate
     * @param $sendAsMail
     * @return Response|string
     */
    public function invoice(GuestBoatDates $guestBoatDate, $sendAsMail = false)
    {
        $text = view('admin.guestBoatDates.invoice', [
            'data'      => $guestBoatDate,
            'settings'  => ConfigSetting::first(),
            'prices'    => $guestBoatDate->priceData,
        ]);
        $html = Str::of($text)->markdown();
        /**
         * @var $pdf PDF
         */
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);

        if($sendAsMail) {
            return $pdf->output();
        }

        $fileName = Carbon::today()->format('Ymd').'_'.Str::slug(config('app.name')) . '_rechnung.pdf';
        return $pdf->download($fileName);
    }

    /**
     * @param GuestBoatDates $guestBoatDate
     * @return RedirectResponse
     */
    public function sendInvoice(GuestBoatDates $guestBoatDate)
    {
        try {
            Mail::send(new GuestBoatInvoiceMail($guestBoatDate, $this->invoice($guestBoatDate, true)));
            return redirect()->route('admin.guestBoatDates.index')->with('success', 'Rechnung erfolgreich an '.$guestBoatDate->boat->email.' versand!');
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param GuestBoatDates $guestBoatDate
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggle(GuestBoatDates $guestBoatDate, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            $guestBoatDate->update([$attribute => $value]);
            $guestBoatDate->refresh();
            return response()->json($guestBoatDate);
        }
        return response()->json(['error' => 'no ajax request']);
    }
}

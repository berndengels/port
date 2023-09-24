<?php

namespace App\Http\Controllers\Admin;

use App\Mail\SendExcel;
use App\Exports\BoatDatesExport;
use App\Http\Requests\BoatDatesRequest;
use App\Mail\InvoiceMail;
use App\Models\Boat;
use App\Models\BoatDates;
use App\Models\ConfigBoatPrice;
use App\Models\ConfigEntity;
use App\Models\ConfigSetting;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 *
 */
class AdminBoatDatesController extends AdminController
{
    /**
     * @var Repository|Application|mixed
     */
    protected $datesModi;
    protected $priceComponents;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->monthsByYear = BoatDates::getMonthsByYearsOptions();
        $this->years = array_keys($this->monthsByYear);
        $this->datesModi = config('port.main.boat.dates.modi');
        $this->priceComponents = ConfigEntity::with('priceComponents')
	        ->whereModel(Boat::class)
            ->first()
            ->priceComponents
        ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $boat 	= $request->input('boat');
        $saison = $request->input('saison');
        $from   = $request->input('from');
        $until  = $request->input('until');

        if($from) {
            $from = Carbon::make($from);
        }
        if($until) {
            $until = Carbon::make($until);
        }

        if($boat) {
//            $from   = null;
//            $until  = null;
//            $saison = null;
        }

        if($from || $until || $saison) {
//            $boatId = null;
        }

        /**
         * @var $query Builder
         */
        $query = BoatDates::with('boat')->sortable();

        $firstDate = Carbon::make(BoatDates::min('from'));
        $lastDate = Carbon::make(BoatDates::max('until'));

        if(!$from && $firstDate) {
            $from = $firstDate;
        }
        if(!$until && $lastDate) {
            $until = $lastDate;
        }

        if($saison) {
            $query->whereModus($saison);
        }
		if($boat) {
			$query->whereBoatId($boat);
		}

        $query->datesBetween($from, $until);

        $paginated  = $query->paginate($this->paginatorLimit);
        $priceTotal = $query->get()->sum(fn ($item) => $item->price);
        $queryString = $request->only(['boat','year','from','until','sort']);

        return view('admin.boatDates.index', [
            'data'          => $paginated,
            'priceTotal'    => $priceTotal,
            'boatOptions'   => $this->boatRepository->options('name')->getSelectOptions()->prepend('Boot wählen', null),
            'saisonOptions' => $this->boatRepository->getBoatSaisonOptions()->prepend('Alle', ''),
            'priceTotal'    => $priceTotal,
            'boat'          => $boat,
            'saison'        => $saison,
            'from'          => $from,
            'until'         => $until,
            'firstDate'     => $firstDate,
            'lastDate'      => $lastDate,
            'queryString'   => $queryString,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  BoatDates $boatDates
     * @return Response
     */
    public function show(BoatDates $boatDate)
    {
        $priceData = $boatDate->getPriceDataAttribute();
        return view('admin.boatDates.show', compact('boatDate','priceData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $today      = Carbon::today();
        $year       = $today->format('Y');
        $nextYear   = $today->copy()->addYear()->format('Y');
        $boatPrices = ConfigBoatPrice::with('saison')->get();

        $winter = $boatPrices->filter(fn(ConfigBoatPrice $p) => $p->saison->mode === 'winter')->first();
        $summer = $boatPrices->filter(fn(ConfigBoatPrice $p) => $p->saison->mode === 'summer')->first();

        $defaultFromWinter    = Carbon::make($year . '-' . $winter->saison->from_month . '-' . $winter->saison->from_day);
        $defaultUntilWinter   = Carbon::make($nextYear . '-' . $winter->saison->until_month . '-' . $winter->saison->until_day);
        $defaultFromSummer    = Carbon::make($year . '-' . $summer->saison->from_month . '-' . $summer->saison->from_day);
        $defaultUntilSummer   = Carbon::make($year . '-' . $summer->saison->until_month . '-' . $summer->saison->until_day);

        $options = $this->boatRepository->options('name');
        $this->boatOptions = $options->getSelectOptions()->prepend('Boot wählen','');

        return view(
            'admin.boatDates.create', [
                'modus'                 => $request->modus ?? 'summer',
                'priceComponents'       => $this->priceComponents,
                'datesModi'             => $this->datesModi,
                'boatOptions'           => $this->boatOptions,
                'defaultFromWinter'     => $defaultFromWinter->format('Y-m-d'),
                'defaultUntilWinter'    => $defaultUntilWinter->format('Y-m-d'),
                'defaultFromSummer'     => $defaultFromSummer->format('Y-m-d'),
                'defaultUntilSummer'    => $defaultUntilSummer->format('Y-m-d'),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BoatDatesRequest $request
     * @return Response
     */
    public function store(BoatDatesRequest $request)
    {
        $validated  = $request->validated();
        $modus      = $validated['modus'];
        $request    = new Request();
        $request->request->add($validated);

        try {
            BoatDates::create($validated);
            return redirect()->route('admin.boatDates.'.$modus)->with('success', 'Boot Date erfolgreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatDates.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  BoatDates $boatDates
     * @return Response
     */
    public function edit(BoatDates $boatDate)
    {
//        $boatDate->load('boat');
        $options = $this->boatRepository->options('name');
        $this->boatOptions = $options->getSelectOptions();

        return view('admin.boatDates.edit', [
                'boatDate'          => $boatDate,
                'modus'             => $boatDate->modus,
                'datesModi'         => $this->datesModi,
                'boatOptions'       => $this->boatOptions,
                'priceComponents'   => $this->priceComponents,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BoatDatesRequest $request
     * @param  BoatDates        $boatDates
     * @return Response
     */
    public function update(BoatDatesRequest $request, BoatDates $boatDate)
    {
        $validated = $request->validated();
        $modus     = $validated['modus'];
        try {
            $boatDate->update($validated);
            return redirect()->route('admin.boatDates.'.$modus)->with('success', 'Boot Date erfolgreich geändert!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatDates.edit', $boatDate)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  BoatDates $boatDates
     * @return Response
     */
    public function destroy(BoatDates $boatDate)
    {
        try {
            $boatDate->delete();
            return redirect()->route('admin.boatDates.index')->with('success', 'Boot Date erfolgreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatDates.index')->with('error', $e->getMessage());
        }
    }

    /**
     * @param BoatDates $boatDate
     * @param $sendAsMail
     * @return Response|string
     */
    public function invoice(BoatDates $boatDate, $sendAsMail = false)
    {
        $text = view('admin.boatDates.invoice', [
            'data'      => $boatDate,
            'customer'  => $boatDate->boat->customer,
            'settings'  => ConfigSetting::first(),
//            'prices'    => $boatDate->getPriceDataAttribute(),
            'prices'    => $boatDate->priceData,
            'modus'     => config('port.main.boat.dates.modi')[$boatDate->modus],
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
     * @param BoatDates $boatDate
     * @return RedirectResponse
     */
    public function sendInvoice(BoatDates $boatDate)
    {
        try {
            Mail::send(new InvoiceMail($boatDate, $this->invoice($boatDate, true)));
            return redirect()->route('admin.boatDates.'.$boatDate->modus)->with('success', 'Rechnung erfolgreich an '.$boatDate->boat->customer->email.' versand!');
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param Request $request
     * @param $year
     * @param $month
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
        $fileName   = $now.'_boat_dates.xls';
        $subject    = "Dauerlieger Umsatz-Daten $strFrom - $strUntil";

        try {
            $export = new BoatDatesExport($from, $until);
            Mail::send(new SendExcel(
                    recipient:  $request->post('email'),
                    export: $export,
                    fileName: $fileName,
                    subject: $subject,
                    dateFrom: $from,
                    dateUntil: $until
                )
            );
            return redirect()->route('admin.boatDates.index')->with(['success' => 'Excel-Datei erfolgreich versand!']);
        } catch (Exception $e) {
            return redirect()->route('admin.boatDates.index')->with(['error' => 'Excel-Datei konnte nicht versand werden!']);
        }
    }

    public function printPage(BoatDates $boatDate)
    {
        $priceData = $boatDate->getPriceDataAttribute();
        return view('admin.boatDates.print', compact('boatDate','priceData'));
    }

    /**
     * @param BoatDates $boatDate
     * @param Request $request
     * @return void
     */
    public function toggle(BoatDates $boatDate, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            $boatDate->update([$attribute => $value]);
            $boatDate->refresh();
            return response()->json($boatDate);
        }
        return response()->json(['error' => 'no ajax request']);
    }
}

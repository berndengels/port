<?php

namespace App\Http\Controllers\Admin;

use Excel;
use App\Mail\SendExcel;
use App\Exports\BoatDatesExport;
use App\Http\Requests\BoatDatesRequest;
use App\Mail\InvoiceMail;
use App\Models\BoatDates;
use App\Models\ConfigBoatPrice;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminBoatDatesController extends AdminController
{
    protected $datesModi;

    public function __construct()
    {
        parent::__construct();
        $this->monthsByYear = BoatDates::getMonthsByYears();
        $this->years = array_keys($this->monthsByYear);
        $this->datesModi = config('port.main.boat.dates.modi');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $uri = explode('/', $request->getRequestUri());
        $modus  = array_pop($uri);
        $modus  = in_array($modus, ['saison','winter']) ? $modus : null;
        $boatId = $request->input('boat');
        $year   = $request->input('year');
        $month  = $request->input('month');

        if($year || $month) {
            $boatId = null;
        }

        if($boatId) {
            $year = null;
            $month = null;
        }

        /**
         * @var $query Builder
         */
        $query = BoatDates::with('boat')
            ->orderByDesc('from');

        if($modus) {
            $query->whereModus($modus);
        }

        $data = $query
            ->boatByDates($guestBoatId ?? null)
            ->fromYearMonth($year, $month);


        $yearOptions = BoatDates::yearOptions();
        $monthOptions = BoatDates::monthOptions();
        $priceTotal = $query->get()->sum(fn ($item) => $item->price);
        $paginated  = $data->paginate($this->paginatorLimit);
        $queryString = $request->only(['boat', 'year', 'month','modus']);

        return view('admin.boatDates.index', [
            'data'          => $paginated,
            'priceTotal'    => $priceTotal,
            'boatOptions'   => $this->boatRepository->options('boat_name')->getSelectOptions(),
            'years'         => $this->years,
            'monthsByYear'  => $this->monthsByYear,
            'yearOptions'   => $yearOptions,
            'monthOptions'  => $monthOptions,
            'priceTotal'    => $priceTotal,
            'boat'          => $boatId,
            'year'          => $year,
            'month'         => $month,
            'queryString'   => $queryString,
            'modus'         => $modus,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
/*
    public function saison()
    {
        $modus = 'saison';
        $query = BoatDates::with('boat')
            ->whereModus('saison')
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);
        $priceTotal = $query->get()->sum(
            function ($item) {
                return $item->price;
            }
        );
        return view('admin.boatDates.index', compact('data', 'modus', 'priceTotal'));
    }
*/
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
/*
    public function winter()
    {
        $modus = 'winter';
        $query = BoatDates::with('boat')
            ->whereModus('winter')
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);
        $priceTotal = $query->get()->sum(
            function ($item) {
                return $item->price;
            }
        );
        return view('admin.boatDates.index', compact('data', 'modus', 'priceTotal'));
    }
*/
    /**
     * Display the specified resource.
     *
     * @param  BoatDates $boatDates
     * @return Response
     */
    public function show(BoatDates $boatDate)
    {
        return view('admin.boatDates.show', compact('boatDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $today = Carbon::today();
        $year = $today->format('Y');
        $nextYear = $today->copy()->addYear()->format('Y');

        $boatPrices = ConfigBoatPrice::with('saison')->get();

        if('saison' === $request->modus) {
            $summer = $boatPrices->filter(fn(ConfigBoatPrice $p) => $p->saison->key === 'summer')->first();
            $defaultFrom    = Carbon::make($year . '-' . $summer->saison->from_month . '-' . $summer->saison->from_day);
            $defaultUntil   = Carbon::make($year . '-' . $summer->saison->until_month . '-' . $summer->saison->until_day);
        } else {
            $winter = $boatPrices->filter(fn(ConfigBoatPrice $p) => $p->saison->key === 'winter')->first();
            $defaultFrom    = Carbon::make($year . '-' . $winter->saison->from_month . '-' . $winter->saison->from_day);
            $defaultUntil   = Carbon::make($nextYear . '-' . $winter->saison->until_month . '-' . $winter->saison->until_day);
        }
        $options = $this->boatRepository->options('boat_name');
        $this->boatOptions = $options->getSelectOptions();

        return view(
            'admin.boatDates.create', [
            'modus'         => $request->modus ?? 'saison',
            'datesModi'     => $this->datesModi,
            'boatOptions'   => $this->boatOptions,
            'defaultFrom'   => $defaultFrom->format('Y-m-d'),
            'defaultUntil'  => $defaultUntil->format('Y-m-d'),
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
        $boatDate->load('boat');
        $options = $this->boatRepository->options('boat_name');
        $this->boatOptions = $options->getSelectOptions();

        return view(
            'admin.boatDates.edit', [
            'boatDate'      => $boatDate,
            'modus'         => $boatDate->modus,
            'datesModi'     => $this->datesModi,
            'boatOptions'   => $this->boatOptions,
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

    public function invoice(BoatDates $boatDate, $sendAsMail = false)
    {
        $text = view(
            'admin.boatDates.invoice', [
            'data'      => $boatDate,
            'customer'  => $boatDate->boat->customer,
            'prices'    => json_decode($boatDate->prices),
            'modus'     => config('port.main.boat.dates.modi')[$boatDate->modus],
            ]
        );
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

    public function sendInvoice(BoatDates $boatDate)
    {
        try {
            Mail::send(new InvoiceMail($boatDate, $this->invoice($boatDate, true)));
            return redirect()->route('admin.boatDates.'.$boatDate->modus)->with('success', 'Rechnung erfolgreich an '.$boatDate->boat->customer->email.' versand!');
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function sendExcel(Request $request, $year = null, $month = null)
    {
        $email      = $request->post('email');
        $now        = Carbon::now()->format('Ymd-Hi');
        $fileName   = $now.'_boat_dates.xls';
        $fullPath   = storage_path('app/temp/'.$fileName);

        try {
            $export = new BoatDatesExport($year, $month);
            if(Excel::store($export, $fileName, 'temp')) {
                Mail::send(new SendExcel($email, $export, $fullPath));
            }
            unlink($fullPath);
            return back()->with(['success' => 'Excel-Datei erfolgreich versand!']);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Excel-Datei konnte nicht versand werden!']);
        }
    }

}

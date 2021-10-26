<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BoatDatesRequest;
use App\Mail\InvoiceMail;
use App\Models\Boat;
use App\Models\BoatDates;
use App\Repositories\BoatRepository;
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
        $this->datesModi = config('port.main.boat.dates.modi');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        /**
         * @var $query Builder
         */
        $query = BoatDates::with('boat')
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);
        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(function ($item) {
            return $item->price;
        });

        return view('admin.boatDates.index', compact('data','priceTotal'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function saison()
    {
        $modus = 'saison';
        /**
         * @var $query Builder
         */
        $query = BoatDates::with('boat')
            ->whereModus('saison')
            ->orderByDesc('from')
        ;
        $data = $query->paginate($this->paginatorLimit);
        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(function ($item) {
            return $item->price;
        });

        return view('admin.boatDates.index', compact('data','modus', 'priceTotal'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function winter()
    {
        $modus = 'winter';
        /**
         * @var $query Builder
         */
        $query = BoatDates::with('boat')
            ->whereModus('winter')
            ->orderByDesc('from')
        ;
        $data = $query->paginate($this->paginatorLimit);
        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(function ($item) {
            return $item->price;
        });

        return view('admin.boatDates.index', compact('data','modus', 'priceTotal'));
    }

    /**
     * Display the specified resource.
     *
     * @param BoatDates $boatDates
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

        if('saison' === $request->modus) {
            $defaultFrom    = Carbon::create($year .'-'. config('port.prices.boat.saison_start'));
            $defaultUntil   = Carbon::create($year .'-'. config('port.prices.boat.saison_end'));
        } else {
            $defaultFrom    = Carbon::create($year .'-'. config('port.prices.boat.winter_start'));
            $defaultUntil   = Carbon::create($nextYear .'-'. config('port.prices.boat.winter_end'));
        }
        $options = $this->boatRepository->options('boat_name');
        $this->boatOptions = $options->getSelectOptions();

        return view('admin.boatDates.create', [
            'modus'         => $request->modus ?? 'saison',
            'datesModi'     => $this->datesModi,
            'boatOptions'   => $this->boatOptions,
            'defaultFrom'   => $defaultFrom->format('Y-m-d'),
            'defaultUntil'  => $defaultUntil->format('Y-m-d'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BoatDatesRequest $request
     * @return Response
     */
    public function store(BoatDatesRequest $request)
    {
        $validated  = $request->validated();
        $modus      = $validated['modus'];
        try {
            BoatDates::create($validated);
            return redirect()->route('admin.boatDates.'.$modus)->with('success', 'Boot Date erfogreich angelegt!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatDates.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BoatDates $boatDates
     * @return Response
     */
    public function edit(BoatDates $boatDate)
    {
        $boatDate->load('boat');
        $options = $this->boatRepository->options('boat_name');
        $this->boatOptions = $options->getSelectOptions();

        return view('admin.boatDates.edit', [
            'boatDate'      => $boatDate,
            'modus'         => $boatDate->modus,
            'datesModi'     => $this->datesModi,
            'boatOptions'   => $this->boatOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BoatDatesRequest $request
     * @param BoatDates $boatDates
     * @return Response
     */
    public function update(BoatDatesRequest $request, BoatDates $boatDate)
    {
        $validated = $request->validated();
        $modus     = $validated['modus'];
        try {
            $boatDate->update($validated);
            return redirect()->route('admin.boatDates.'.$modus)->with('success', 'Boot Date erfogreich geändert!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatDates.edit', $boatDate)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BoatDates $boatDates
     * @return Response
     */
    public function destroy(BoatDates $boatDate)
    {
        try {
            $boatDate->delete();
            return redirect()->route('admin.boatDates.index')->with('success', 'Boot Date erfogreich gelöscht!');
        } catch(Exception $e) {
            return redirect()->route('admin.boatDates.index')->with('error', $e->getMessage());
        }
    }

    public function invoice(BoatDates $boatDate, $sendAsMail = false)
    {
        $text = view('admin.boatDates.invoice', [
            'data'      => $boatDate,
            'customer'  => $boatDate->boat->customer,
            'prices'    => json_decode($boatDate->prices),
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

        return $pdf->download('rechnung.pdf');
    }

    public function sendInvoice(BoatDates $boatDate) {
        try {
            Mail::send(new InvoiceMail($boatDate, $this->invoice($boatDate, true)));
            return redirect()->route('admin.boatDates.'.$boatDate->modus)->with('success', 'Rechnung erfogreich an '.$boatDate->boat->customer->email.' versand!');
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}

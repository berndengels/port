<?php

namespace App\Http\Controllers;

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

class BoatDatesController extends Controller
{
    protected $datesModi;

    public function __construct()
    {
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
            ->whereIn('boat_id', auth('customer')->user()->boats->map->id)
            ->orderByDesc('from')
        ;
        $data = $query->paginate($this->paginatorLimit);
        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(
            function ($item) {
                return $item->price;
            }
        );

        return view('customer.boatDates.index', compact('data', 'priceTotal'));
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
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);
        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(
            function ($item) {
                return $item->price;
            }
        );

        return view('customer.boatDates.index', compact('data', 'modus', 'priceTotal'));
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
            ->orderByDesc('from');
        $data = $query->paginate($this->paginatorLimit);
        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(
            function ($item) {
                return $item->price;
            }
        );

        return view('customer.boatDates.index', compact('data', 'modus', 'priceTotal'));
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
        return view('customer.boatDates.show', compact('boatDate','priceData'));
    }

    public function invoice(BoatDates $boatDate, $sendAsMail = false)
    {
        $text = view(
            'customer.boatDates.invoice', [
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
            Mail::send(new InvoiceMail($boatDate, $this->invoice($boatDate)));
            return redirect()->route('customer.boatDates.'.$boatDate->modus)->with('success', 'Rechnung erfolgreich an '.$boatDate->boat->customer->email.' versand!');
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function printPage(BoatDates $boatDate)
    {
        $priceData = $boatDate->getPriceDataAttribute();
        return view('customer.boatDates.print', compact('boatDate','priceData'));
    }
}

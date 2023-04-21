<?php
namespace App\Http\Controllers\Admin;

use App\Mail\CaravanInvoiceMail;
use App\Models\ConfigSetting;
use Barryvdh\DomPDF\PDF;
use Exception;
use Carbon\Carbon;
use App\Mail\SendExcel;
use App\Rules\CaravanDatesIntervalUnique;
use App\Exports\CaravanDatesExport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;
use App\Models\Caravan;
use App\Models\CaravanDates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CaravanDatesRequest;
use App\Http\Requests\CaravanDatesValidationData;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminCaravanDatesController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $caravanId  = $request->input('caravan');
        $dublicatéId = $request->input('dublicate');
        $from       = $request->input('from');
        $until      = $request->input('until');

        if($from) {
            $from = Carbon::make($from);
        }
        if($until) {
            $until = Carbon::make($until);
        }

        if($from || $until) {
            $caravanId = null;
            $dublicatéId = null;
        }

        if($dublicatéId || $caravanId) {
            $from = null;
            $until = null;
        }

        /**
         * @var $query Builder
         */
        $query = CaravanDates::with('caravan')->sortable();

        $firstDate = Carbon::make(CaravanDates::min('from'));
        $lastDate = Carbon::make(CaravanDates::max('until'));

        if(!$from) {
            $from = $firstDate;
        }
        if(!$until) {
            $until = $lastDate;
        }

        $dublicate = CaravanDates::dublicates()
            ->get()
            ->keyBy('caravan_id')
            ->sortByDesc('anzahl')
            ->map(
                function ($item) {
                    return "$item->carnumber";
                }
            );
        $dublicateOptions = $dublicate->count() ? $dublicate->prepend('Dublikat wählen', '') : null;

        $data = $query
            ->caravanById($caravanId ?? $dublicatéId)
            ->datesBetween($from, $until)
        ;

        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(fn ($item) => (int) $item->price);

        $paginated = $data->paginate($this->paginatorLimit);
        $queryString = $request->only(['caravan','dublicate','from', 'until','sort']);

        return view('admin.caravanDates.index', [
            'data'              => $paginated,
            'caravanOptions'    => $this->caravanRepository->options('carnumber')->getSelectOptions()->prepend('Kennzeichen wählen', null),
            'dublicateOptions'  => $dublicateOptions,
            'priceTotal'        => $priceTotal,
            'caravan'           => $caravanId,
            'dublicate'         => $dublicatéId,
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
     * @param  CaravanDates $caravanDate
     * @return Response
     */
    public function show(CaravanDates $caravanDate)
    {
        $caravanDate->load('caravan');
        $priceData = $caravanDate->getPriceDataAttribute();
        return view('admin.caravanDates.show', compact('caravanDate','priceData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view(
            'admin.caravanDates.create', [
            'caravanOptions' => $this->caravanRepository->options('carnumber')->getSelectOptionsData()->prepend('Kennzeichen wählen', null)->toJson(),
            'countries' => $this->countryRepository->options('de')->getSelectOptions(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $carnumber  = $request->post('carnumber');
        $caravan    = Caravan::whereCarnumber($carnumber)->first() ?? new Caravan();
        $validationData = new CaravanDatesValidationData($request);
        $request    = $validationData->getRequest();

        $rules  = $validationData->rules();
        $rules['until']  = array_merge($rules['until'], [new CaravanDatesIntervalUnique($caravan)]);

        $validator  = Validator::make($request->all(), $rules, $validationData->messages());
        $validator->validate();

        try {
            $validated = collect($validator->validated())->only(['country_id','carnumber','carlength','email'])->toArray();
            $caravan->fill($validated)->save();

            $validated  = collect($validator->validated())->except(['country_id','carnumber','carlength','email'])->toArray();
            $caravanDate = $caravan->dates()->create($validated);

            return redirect()->route('admin.caravanDates.show', $caravanDate)->with(['success' => "Caravan-Eintrag erfolgreich angelegt"]);

        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CaravanDates $caravanDate
     * @return Response
     */
    public function edit(CaravanDates $caravanDate)
    {
        $caravanDate->load('caravan');
        $countries = $this->countryRepository->options('de')->getSelectOptions();
        $caravanOptions = $this->caravanRepository->options('carnumber')->getSelectOptionsData()->toJson();

        return view('admin.caravanDates.edit', compact('caravanDate', 'caravanOptions', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CaravanDatesRequest $request
     * @param  CaravanDates        $caravanDate
     * @return Response
     */
    public function update(CaravanDatesRequest $request, CaravanDates $caravanDate)
    {
        $validated = collect($request->validated());
        $validatedCaravan = $validated->only(['carnumber','carlength','email'])->toArray();
        $validatedCaravanDates = $validated->except(['carnumber','carlength','email'])->toArray();
        try {
            $caravanDate->caravan()->update($validatedCaravan);
            $caravanDate->update($validatedCaravanDates);
            return redirect()->route('admin.caravanDates.index')->with(['success' => "Caravan-Eintrag mit ID: $caravanDate->id erfolgreich geändert"]);
        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CaravanDates $caravanDate
     * @return Response
     */
    public function destroy(CaravanDates $caravanDate)
    {
        $id = $caravanDate->id;
        $caravanDate->delete();
        return back()->with(['success' => "Caravan-Eintrag mit ID: $id erfolgreich gelöscht!"]);
    }

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
        $fileName   = $now.'_caravan_dates.xls';
        $subject    = "Caravan Umsatz-Daten $strFrom - $strUntil";

        try {
            $export = new CaravanDatesExport($from, $until);
            $content = $export->raw(\Maatwebsite\Excel\Excel::XLS);
            Mail::send(new SendExcel(
                recipient:  $request->post('email'),
                export: $export,
                fileName: $fileName,
                subject: $subject,
                dateFrom: $from,
                dateUntil: $until
            ));
            return redirect()->route('admin.caravanDates.index')->with(['success' => 'Excel-Datei erfolgreich versand!']);
        } catch (Exception $e) {
            return redirect()->route('admin.caravanDates.index')->with(['error' => 'Excel-Datei konnte nicht versand werden!<br>'.$e->getMessage()]);
        }
    }

    public function printPage(CaravanDates $caravanDate)
    {
        $priceData = $caravanDate->getPriceDataAttribute();
        return view('admin.caravanDates.print', compact('caravanDate','priceData'));
    }

    public function invoice(CaravanDates $caravanDate, $sendAsMail = false)
    {
        $text = view('admin.caravanDates.invoice', [
            'data'      => $caravanDate,
            'settings'  => ConfigSetting::first(),
            'prices'    => $caravanDate->priceData,
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
    public function sendInvoice(CaravanDates $caravanDate)
    {
        try {
            Mail::send(new CaravanInvoiceMail($caravanDate, $this->invoice($caravanDate, true)));
            return redirect()->route('admin.caravanDates.index')->with('success', 'Rechnung erfolgreich an '.$caravanDate->caravan->email.' versand!');
        } catch(Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function toggle(CaravanDates $caravanDate, Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $attribute  = $request->post('attribute');
            $value      = (bool) $request->post('value');
            $caravanDate->update([$attribute => $value]);
            $caravanDate->refresh();
            return response()->json($caravanDate);
        }
        return response()->json(['error' => 'no ajax request']);
    }
}

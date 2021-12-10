<?php
namespace App\Http\Controllers\Admin;

use Excel;
use App\Mail\SendExcel;
use App\Exports\CaravanDatesExport;
use App\Rules\DatesIntervalUnique;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use App\Models\Caravan;
use App\Models\CaravanDates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CaravanDatesRequest;
use App\Http\Requests\CaravanDatesValidationData;
use Illuminate\Support\Facades\Mail;

class AdminCaravanDatesController extends AdminController
{
    private $years;
    private $monthsByYear;

    public function __construct()
    {
        $this->monthsByYear = CaravanDates::getMonthsByYears();
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
        $caravanId  = $request->input('caravan');
        $dublicatéId = $request->input('dublicate');
        $year       = $request->input('year');
        $month      = $request->input('month');

        if($year || $month) {
            $caravanId = null;
            $dublicatéId = null;
        }

        if($dublicatéId || $caravanId) {
            $year = null;
            $month = null;
        }

        /**
         * @var $query Builder
         */
        $query = CaravanDates::with('caravan')
            ->orderByDesc('from');

        $dublicateOptions = CaravanDates::dublicates()
            ->get()
            ->keyBy('caravan_id')
            ->sortByDesc('anzahl')
            ->map(
                function ($item) {
                    return "$item->carnumber";
                }
            )
            ->prepend('Dublikat wählen', '');

        $yearOptions = CaravanDates::yearOptions();
        $monthOptions = CaravanDates::monthOptions();

        $data = $query
            ->caravanByDates($caravanId ?? $dublicatéId)
            ->fromYearMonth($year, $month);

        /**
         * @var $priceTotal Collection
         */
        $priceTotal = $query->get()->sum(fn ($item) => $item->price);

        $paginated = $data->paginate($this->paginatorLimit);
        $queryString = $request->only(['caravan','dublicate','year', 'month']);

        return view(
            'admin.caravanDates.index', [
            'data'              => $paginated,
            'years'             => $this->years,
            'monthsByYear'      => $this->monthsByYear,
            'caravanOptions'    => $this->caravanRepository->options('carnumber')->getSelectOptions(),
            'dublicateOptions'  => $dublicateOptions,
            'yearOptions'       => $yearOptions,
            'monthOptions'      => $monthOptions,
            'priceTotal'        => $priceTotal,
            'caravan'           => $caravanId,
            'dublicate'         => $dublicatéId,
            'year'              => $year,
            'month'             => $month,
            'queryString'       => $queryString,
            ]
        );
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
        return view('admin.caravanDates.show', compact('caravanDate'));
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
            'caravanOptions' => $this->caravanRepository->options('carnumber')->getSelectOptionsData()->toJson(),
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
        $validationData = new CaravanDatesValidationData($request, $caravan);
        $request    = $validationData->getRequest();

        $rules  = $validationData->rules();
        $rules['until']  = array_merge($rules['until'], [new DatesIntervalUnique($caravan)]);

        $validator  = Validator::make($request->all(), $rules, $validationData->messages());
        $validator->validate();

        $validated = collect($validator->validated())->only(['country_id','carnumber','carlength','email'])->toArray();
        $caravan->fill($validated)->save();

        $validated  = collect($validator->validated())->except(['country_id','carnumber','carlength','email'])->toArray();
        $caravanDate = $caravan->dates()->create($validated);

        //        return back()->with(['success' => "Caravan-Eintrag mit ID: $caravanDate->id erfolgreich angelegt"]);
        return $this->show($caravanDate);
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
        $year       = $request->post('year');
        $month      = $request->post('month');
        $now        = Carbon::now()->format('Ymd-Hi');
        $fileName   = $now.'_caravan_dates.xls';
        $subject    = 'Caravan Daten';

        try {
            $export = new CaravanDatesExport($year, $month);
            Mail::send(new SendExcel(
                recipient:  $request->post('email'),
                export: $export,
                fileName: $fileName,
                subject: $subject,
                year: $year,
                month: $month
                )
            );
            return redirect()->route('admin.caravanDates.index')->with(['success' => 'Excel-Datei erfolgreich versand!']);
        } catch (Exception $e) {
            return redirect()->route('admin.caravanDates.index')->with(['error' => 'Excel-Datei konnte nicht versand werden!']);
        }
    }
}

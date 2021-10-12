<?php
namespace App\Http\Controllers\Admin;

use App\Mail\SendExcel;
use Excel;
use App\Exports\CaravanDatesExport;
use App\Rules\DatesIntervalUnique;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use App\Models\Caravan;
use App\Models\CaravanDates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
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
            ->orderByDesc('from')
        ;
        $dublicateOptions = CaravanDates::dublicates()
            ->get()
            ->keyBy('caravan_id')
            ->sortByDesc('anzahl')
            ->map(function($item) {
                return "$item->carnumber";
            })
            ->prepend('Dublikat wählen', '')
        ;

        $yearOptions = CaravanDates::selectRaw('YEAR(`from`) AS year')
            ->groupByRaw('year')
            ->get()
            ->keyBy('year')
            ->map
            ->year
            ->prepend('Jahr wählen', '')
        ;

        $monthOptions = CaravanDates::selectRaw('MONTH(`from`) AS number, MONTHNAME(`from`) AS monthname')
            ->groupByRaw('number')
            ->get()
            ->keyBy('number')
            ->map
            ->monthname
            ->prepend('Monat wählen', '')
        ;
        $data = $query
            ->caravanByDates($caravanId ?? $dublicatéId)
            ->fromYearMonth($year, $month)
        ;

        /**
         * @var $priceTotal \Illuminate\Database\Eloquent\Collection
         */
        $priceTotal = $data->get();
        $priceTotal = $priceTotal->sum(function ($item) {
            return $item->price;
        });

        $paginated = $data->paginate($this->paginatorLimit);
        $queryString = $request->only(['caravan','dublicate','year', 'month']);

        return view('admin.caravanDates.index', [
            'data'              => $paginated,
            'years'             => $this->years,
            'monthsByYear'      => $this->monthsByYear,
            'caravanOptions'    => $this->caravanOptions,
            'dublicateOptions'  => $dublicateOptions,
            'yearOptions'       => $yearOptions,
            'monthOptions'      => $monthOptions,
            'priceTotal'        => $priceTotal,
            'caravan'           => $caravanId,
            'dublicate'         => $dublicatéId,
            'year'              => $year,
            'month'             => $month,
            'queryString'       => $queryString,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param CaravanDates $caravanDate
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
        return view('admin.caravanDates.create', [
            'caravanOptions' => $this->caravanOptionsAutocomplete->toJson(),
            'countries' => $this->countries,
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
     * @param CaravanDates $caravanDate
     * @return Response
     */
    public function edit(CaravanDates $caravanDate)
    {
        $countries = $this->countries;
        $caravanOptions = $this->caravanOptions;
        $caravanDate->load('caravan');
        return view('admin.caravanDates.edit', compact('caravanDate','caravanOptions', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CaravanDatesRequest $request
     * @param CaravanDates $caravanDate
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
            return back()->with(['success' => "Caravan-Eintrag mit ID: $caravanDate->id erfolgreich geändert"]);
        } catch(Exception $e) {
            return back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CaravanDates $caravanDate
     * @return Response
     */
    public function destroy(CaravanDates $caravanDate)
    {
        $id = $caravanDate->id;
        $caravanDate->delete();
        return back()->with(['success' => "Caravan-Eintrag mit ID: $id erfolgreich gelöscht!"]);
    }

    public function sendExcel(Request $request, $year = null, $month = null)
    {
        $email      = $request->post('email');
        $now        = Carbon::now()->format('Ymd-Hi');
        $fileName   = $now.'_caravan_dates.xls';
        $fullPath   = storage_path('app/temp/'.$fileName);

        try {
            $export = new CaravanDatesExport($year, $month);

            if(Excel::store($export, $fileName, 'temp')) {
                Mail::send(new SendExcel($email, $export, $fullPath));
            }
            unlink($fullPath);
//            return response()->json(['success' => true, 'error' => null]);
            return back()->with(['success' => 'Excel-Datei erfolgreich versand!']);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Excel-Datei konnte nicht versand werden!']);
        }
    }
}

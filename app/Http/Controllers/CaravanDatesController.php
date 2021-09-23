<?php
namespace App\Http\Controllers;

use App\Mail\SendExcel;
use Excel;
use App\Exports\CaravanDatesExport;
use App\Models\Country;
use App\Rules\DatesIntervalUnique;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use App\Models\Caravan;
use App\Models\CaravanDates;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CaravanDatesRequest;
use App\Http\Requests\CaravanDatesValidationData;
use Illuminate\Support\Facades\Mail;

class CaravanDatesController extends Controller
{
    private $caravans;
    private $years;
    private $monthsByYear;
    private $countries;

    public function __construct()
    {
        $this->caravans = Caravan::orderBy('carnumber')->get();
        $this->monthsByYear = CaravanDates::getMonthsByYears();
        $this->years = array_keys($this->monthsByYear);
        $this->countries = Country::orderBy('de')
            ->get(['id','de'])
            ->keyBy('id')
            ->map
            ->de
        ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Inertia::render('CaravanDates/index', [
            'years'         => $this->years,
            'monthsByYear'  => $this->monthsByYear,
            'create_url'    => URL::route('caravanDates.create'),
            'caravans'      => $this->caravans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return Inertia::render('CaravanDates/create', [
            'caravans' => $this->caravans,
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

        return $this->show($caravanDate);
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
        return Inertia::render('CaravanDates/show', compact('caravanDate'));
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
        $caravans = $this->caravans;
        $caravanDate->load('caravan');
        return Inertia::render('CaravanDates/edit', compact('caravanDate','caravans','countries'));
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

        $caravanDate->caravan()->update($validatedCaravan);
        $caravanDate->update($validatedCaravanDates);

        return Redirect::route('caravanDates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CaravanDates $caravanDate
     * @return Response
     */
    public function destroy(CaravanDates $caravanDate)
    {
        $caravanDate->delete();
        return Redirect::route('caravanDates.index');
    }

    public function sendExcel(Request $request)
    {
        $email      = $request->post('email');
        $year       = $request->post('year');
        $month      = $request->post('month');

        $now        = Carbon::now()->format('Ymd-Hi');
        $fileName   = $now.'_caravan_dates.xls';
        $fullPath   = storage_path('app/temp/'.$fileName);

        try {
            $export = new CaravanDatesExport($year, $month);

            if(Excel::store($export, $fileName, 'temp')) {
                Mail::send(new SendExcel($email, $export, $fullPath));
            }
            unlink($fullPath);
            return response()->json(['success' => true, 'error' => null]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}

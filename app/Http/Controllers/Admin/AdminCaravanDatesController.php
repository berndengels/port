<?php
namespace App\Http\Controllers\Admin;

use App\Mail\SendExcel;
use Excel;
use App\Exports\CaravanDatesExport;
use App\Rules\DatesIntervalUnique;
use Carbon\Carbon;
use Exception;
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
        $caravanId = $request->input('caravan');

        $query = CaravanDates::with('caravan')
            ->orderByDesc('from');

        if($caravanId) {
            $query->whereCaravanId($caravanId);
        }

        $data = $query->paginate(20);

        return view('admin.caravanDates.index', [
            'data'              => $data,
            'years'             => $this->years,
            'monthsByYear'      => $this->monthsByYear,
            'caravanOptions'    => $this->caravanOptions,
            'caravanId'         => $caravanId,

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

        $caravanDate->caravan()->update($validatedCaravan);
        $caravanDate->update($validatedCaravanDates);

        return Redirect::route('admin.caravanDates.index');
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
        return Redirect::route('admin.caravanDates.index');
    }

    public function sendExcel(Request $request, $from = null)
    {
        $email      = $request->post('email');
        $now        = Carbon::now()->format('Ymd-Hi');
        $fileName   = $now.'_caravan_dates.xls';
        $fullPath   = storage_path('app/temp/'.$fileName);
        if($from) {
            $from = Carbon::create($from);
        }
        try {
            $export = new CaravanDatesExport($from);

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
